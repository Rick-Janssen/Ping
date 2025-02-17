const searchInput = document.getElementById('host-search');
            const hostElements = document.querySelectorAll('.box-container');

            function filterHosts(query) {
                hostElements.forEach(hostElement => {
                    const hostName = hostElement.querySelector('.text-lg').textContent.toLowerCase();
                    if (hostName.includes(query.toLowerCase())) {
                        hostElement.parentElement.style.display = 'block';
                    } else {
                        hostElement.parentElement.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', function() {
                const searchQuery = this.value;
                filterHosts(searchQuery);
            });