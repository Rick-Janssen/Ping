import * as THREE from 'https://cdn.skypack.dev/three@0.129.0/build/three.module.js';
import { OrbitControls } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';

const scene = new THREE.Scene();
const canvas = document.querySelector('.webgl');
const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
const camera = new THREE.PerspectiveCamera(80, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.z = 2;

const textureLoader = new THREE.TextureLoader();
const texture = textureLoader.load('Textures/8k_earth_daymap.jpg');
const cloudTexture = textureLoader.load('textures/earthCloud.png');
const starTexture = textureLoader.load('Textures/galaxy.png');

const earthGeometry = new THREE.SphereGeometry(0.6, 32, 32);
const earthMaterial = new THREE.MeshPhongMaterial({ map: texture });
const earthMesh = new THREE.Mesh(earthGeometry, earthMaterial);
scene.add(earthMesh);

const cloudGeometry = new THREE.SphereGeometry(0.63, 32, 32);
const cloudMaterial = new THREE.MeshPhongMaterial({ map: cloudTexture, transparent: true });
const cloudMesh = new THREE.Mesh(cloudGeometry, cloudMaterial);
scene.add(cloudMesh);

const starGeometry = new THREE.SphereGeometry(80, 64, 64);
const starMaterial = new THREE.MeshBasicMaterial({ map: starTexture, side: THREE.BackSide });
const starMesh = new THREE.Mesh(starGeometry, starMaterial);
scene.add(starMesh);

const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
const pointLight = new THREE.PointLight(0xffffff, 1);
pointLight.position.set(5, 3, 5);
scene.add(ambientLight, pointLight);

const clickableGeometry = new THREE.SphereGeometry(0.007, 32, 32); 
const clickableMaterial = new THREE.MeshBasicMaterial({ transparent: true, opacity: 0 });

const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

const infoBox = document.createElement('div');
infoBox.style.position = 'absolute';
infoBox.style.padding = '10px';
infoBox.style.background = 'white';
infoBox.style.color = 'black';
infoBox.style.borderRadius = '5px';
infoBox.style.display = 'none';
document.body.appendChild(infoBox);

function showInfoBox(hostName, x, y) {
    infoBox.innerHTML = hostName;
    infoBox.style.left = x + 'px';
    infoBox.style.top = y + 'px';
    infoBox.style.display = 'block';
}

function hideInfoBox() {
    infoBox.style.display = 'none';
}

const globeRadius = 0.6;
const maxDistance = globeRadius * 4;
const minDistance = globeRadius + 0.12;
const markers = [];
const followDistance = 0.01;

function addMarker(latitude = 0, longitude = 0, hostName = '', ms = '') {
    const latRad = (latitude * Math.PI) / 180;
    const lonRad = (longitude * Math.PI) / -180;


    const x = globeRadius * Math.cos(latRad) * Math.cos(lonRad);
    const y = globeRadius * Math.sin(latRad);
    const z = globeRadius * Math.cos(latRad) * Math.sin(lonRad);

    const gltfLoader = new GLTFLoader();
    gltfLoader.load('/3Dmodel/map_pointer.glb', (gltf) => {
        const marker = gltf.scene;
        const scaleFactor = 0.002; 
        marker.scale.set(scaleFactor, scaleFactor, scaleFactor);
        let markerColor;

        if (ms !== null && ms < 50) {
            markerColor = 0x00FF00; 
        } else if (ms !== null && ms >= 50 && ms < 80) {
            markerColor = 0xFFFF00; 
        } else if (ms === -1 || (ms > 80 && ms !== null)) {
            markerColor = 0xFF0000;
        } else {
            markerColor = 0x000000; 
        }
        if (ms === -1) {
            markerColor = 0xFF0000; 
        }

        marker.traverse((child) => {
            if (child.isMesh) {
                child.material = new THREE.MeshBasicMaterial({ color: markerColor });
            }
        });

        marker.userData.isMarker = true;
        marker.userData.hostName = hostName;
        marker.userData.latitude = latitude;
        marker.userData.longitude = longitude;

        marker.position.copy(getMarkerPosition(latitude, longitude)); 
        markers.push(marker);
        scene.add(marker);
    });

    const markerPosition = getMarkerPosition(latitude, longitude);
    const offset = 0;
    const clickableAreaPosition = markerPosition.clone().add(new THREE.Vector3(0, 0, offset));
    const clickableArea = new THREE.Mesh(clickableGeometry, clickableMaterial);
    clickableArea.position.copy(clickableAreaPosition);
    clickableArea.userData.hostName = hostName;
    clickableArea.userData.isClickable = true;
    clickableArea.addEventListener("click", function() {
        console.log("Clicked Marker Hostname:", this.userData.hostName);
    });

    scene.add(clickableArea);
}

function getMarkerPosition(latitude, longitude) {
    const latRad = (latitude * Math.PI) / 180;
    const lonRad = (longitude * Math.PI) / -180;
    const x = globeRadius * Math.cos(latRad) * Math.cos(lonRad);
    const y = globeRadius * Math.sin(latRad);
    const z = globeRadius * Math.cos(latRad) * Math.sin(lonRad);
    return new THREE.Vector3(x, y, z);
}

function getMarkerBoundingSize(marker) {
    const box = new THREE.Box3().setFromObject(marker);
    const size = new THREE.Vector3();
    box.getSize(size);
    return size;
}

function updateMarkersPosition() {
    const { x: cameraX, y: cameraY, z: cameraZ } = camera.position;
    markers.forEach((marker) => {
        const { latitude, longitude } = marker.userData;
        const markerPosition = getMarkerPosition(latitude, longitude);
        const distance = camera.position.distanceTo(markerPosition);
        const markerBoundingSize = getMarkerBoundingSize(marker);
        const markerOffsetZ = markerBoundingSize.z * 0.5; // Adjust along the z-axis to touch the globe surface
        markerPosition.z -= markerOffsetZ;
        const offsetDistance = markerBoundingSize.y / 2;
        const offsetPosition = markerPosition.clone().add(camera.position.clone().normalize().multiplyScalar(offsetDistance));
        if (distance < followDistance) {
            marker.position.copy(camera.position);
        } else {
            marker.position.copy(offsetPosition);
        }
        marker.lookAt(camera.position);
    });
}

const controls = new OrbitControls(camera, renderer.domElement);
controls.minDistance = minDistance;
controls.maxDistance = maxDistance;
controls.rotateSpeed = 0.3;
controls.minPolarAngle = Math.PI / 10;
controls.maxPolarAngle = Math.PI - Math.PI / 10; 

function addMarkersFromData(data) {
    data.forEach((host) => {
        addMarker(host.lat, host.lon, host.host_name, host.ms);
    });
    // console.log(data)
}

addMarkersFromData(geolocationData);

window.addEventListener('click', (event) => {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);

    const intersects = raycaster.intersectObjects(scene.children, true);

    if (intersects.length > 0) {
        const clickableObject = intersects.find(obj => obj.object.userData.isClickable);
        if (clickableObject) {
            console.log("click")
            const hostName = clickableObject.object.userData.hostName;
            showInfoBox(hostName, event.clientX, event.clientY);
        } else {
            hideInfoBox();
        }
    } else {
        hideInfoBox();
    }
});
const newWidth = window.innerWidth * 0.793;
const newHeight = window.innerHeight * 0.85;

renderer.setSize(newWidth, newHeight);

camera.aspect = newWidth / newHeight;
camera.updateProjectionMatrix();

canvas.style.position = 'absolute';
canvas.style.left = `10%`;
canvas.style.top = `8rem`;
canvas.style.height = "85%"
canvas.style.width = "80%"

window.addEventListener('mousemove', (event) => {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1.02;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1.1;

    raycaster.setFromCamera(mouse, camera);

    const intersects = raycaster.intersectObjects(scene.children, true);

    if (intersects.length > 0) {
        const clickableObject = intersects.find(obj => obj.object.userData.isClickable);
        if (clickableObject) {
            const hostName = clickableObject.object.userData.hostName;
            showInfoBox(hostName, event.clientX, event.clientY);
        } else {
            hideInfoBox();
        }
    } else {
        hideInfoBox();
    }
});

window.addEventListener('resize', () => {
    const newWidth = window.innerWidth * 0.8;
    const newHeight = window.innerHeight * 0.85;

    renderer.setSize(newWidth, newHeight);

    camera.aspect = newWidth / newHeight;
    camera.updateProjectionMatrix();

    canvas.style.left = `${(window.innerWidth - newWidth) / 2}px`;
}, false);

const animate = () => {
    requestAnimationFrame(animate);
    pointLight.position.copy(camera.position);
    scene.traverse((object) => {
        if (object.userData.isMarker) {
            const markerPosition = object.position.clone();
            markerPosition.applyMatrix4(object.matrixWorld); 
            
            object.traverse((child) => {
                if (child.userData.isClickable) {
                    child.position.copy(markerPosition);
                }
            });
        }
    });

    updateMarkersPosition();

    starMesh.rotation.y -= 0.002;
    cloudMesh.rotation.y -= 0.001;
    controls.update();
    render();
};

const render = () => {
    renderer.render(scene, camera);
};

animate();