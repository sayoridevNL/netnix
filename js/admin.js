// Load movies on page load
document.addEventListener('DOMContentLoaded', function() {
    loadMovies();
    setupFormListener();
});

// Load movies from JSON and display them
function loadMovies() {
    fetch('data/movies.json')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('moviesTableBody');
            tableBody.innerHTML = '';
            
            data.movies.forEach(movie => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${movie.id}</td>
                    <td>${movie.title}</td>
                    <td>${movie.year}</td>
                    <td>${movie.rating}</td>
                    <td>${movie.description.substring(0, 50)}...</td>
                    <td>
                        <button class="action-btn" onclick="editMovie(${movie.id})">Edit</button>
                        <button class="action-btn delete" onclick="deleteMovie(${movie.id})">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error loading movies:', error));
}

// Setup form submission
function setupFormListener() {
    const form = document.getElementById('movieForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const title = document.getElementById('title').value;
        const year = document.getElementById('year').value;
        const rating = document.getElementById('rating').value;
        const description = document.getElementById('description').value;
        
        console.log('Movie added:', { title, year, rating, description });
        alert(`Movie "${title}" has been added!`);
        
        form.reset();
        loadMovies();
    });
}

// Edit movie function
function editMovie(id) {
    alert(`Edit functionality for movie ${id} coming soon!`);
}

// Delete movie function
function deleteMovie(id) {
    if (confirm('Are you sure you want to delete this movie?')) {
        alert(`Movie ${id} has been deleted!`);
        loadMovies();
    }
}
