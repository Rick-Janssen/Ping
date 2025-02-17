$(document).ready(function() {
    function scrollToBottom() {
        $('html, body').animate({
            scrollTop: document.body.scrollHeight
        }, 3000, function() {
            setTimeout(scrollToTop, 12000);
        });
    }

    function scrollToTop() {
        $('html, body').animate({
            scrollTop: 0
        }, 3000, function() {
            setTimeout(scrollToBottom, 12000);
        });
    }

    scrollToBottom();

    function updateErrorAndPingIndicator(hostname, errorMessage, pingValue, hasError) {
        const errorElement = document.getElementById(`error-${hostname}`);
        const msgElement = document.getElementById(`msg-${hostname}`);
        const pingElement = document.getElementById(`ping-${hostname}`);
        
        if (errorElement && pingElement && msgElement) {
            if (pingValue > 0) {
                errorElement.style.backgroundColor = "#1bd127"
                pingElement.textContent = ` ${pingValue} ms`;
            } if (pingValue < 0 ) {
                errorElement.style.backgroundColor = "#c1000c"
            }
            if(hasError){
                msgElement.style.backgroundColor = "#c1000c"
                msgElement.textContent = '!'; 
                msgElement.style.display = 'block';
            } else {
                msgElement.style.display = 'none';
            }

            if (pingValue > 120) {
                errorElement.style.backgroundColor = '#e5a400';
                pingElement.textContent = ` ${pingValue} ms`;
            }

        } else {
            console.log(`Error or ping element not found for ${hostname}`);
        }
    }
    

    function fetchDataAndUpdateUI() {
        fetch('/staticData')
            .then(response => response.json())
            .then(data => {
                Object.keys(data.ping).forEach(hostname => {
                    const pingValue = data.ping[hostname];
                    const hasError = data.error.some(error => error.host_name === hostname);
                    const errorMessage = hasError ? data.error.find(error => error.host_name ===
                        hostname).error : '';
                    updateErrorAndPingIndicator(hostname, errorMessage, pingValue, hasError);
                });

                const messageElement = document.getElementById('message');
                if (messageElement) {
                    messageElement.textContent = data.message;
                } else {
                    console.log('Message element not found');
                }

                const hasErrors = data.error.length > 0;

                const marqueeElement = document.querySelector('.marquee');
                if (marqueeElement) {
                    marqueeElement.style.backgroundColor = hasErrors ? 'red' : '#383f4c';
                } else {
                    console.log('Marquee element not found');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    fetchDataAndUpdateUI();
    setInterval(fetchDataAndUpdateUI, 5000);

    function refresh() {
        window.location.reload();
    }

    setInterval(refresh, 600000)
});