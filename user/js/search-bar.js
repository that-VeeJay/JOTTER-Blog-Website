document.addEventListener('DOMContentLoaded', () => {
    let searchInput = document.getElementById('search-input');
    let searchResultsContainer = document.getElementById('search-results');

    searchInput.addEventListener('input', processInput);

    document.addEventListener('click', (event) => {
        if (!searchResultsContainer.contains(event.target) && !searchInput.contains(event.target)) {
            searchResultsContainer.innerHTML = '';
        }
    });

    async function processInput(event) {
        event.preventDefault();

        const query = searchInput.value.trim();

        if (query.length === 0) {
            searchResultsContainer.innerHTML = '';
            return;
        }

        fetch('search.php', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    searchInput: query
                }).toString()
            })
            .then(response => response.json())
            .then(data => {
                searchResultsContainer.innerHTML = '';
                data.forEach(item => {
                    const resultItem = document.createElement('a');
                    resultItem.className = 'result-data';
                    resultItem.textContent = item.title;
                    resultItem.href = `blog.php?id=${item.id}`;
                    searchResultsContainer.appendChild(resultItem);
                });

            })
    }
})
