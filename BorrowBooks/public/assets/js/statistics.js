document.addEventListener('DOMContentLoaded', () => {
    const fetchTopBooksAndReaders = async () => {
        try {
            const response = await fetch('/statistics/topBooks');
            const { topBooks, readersCount } = await response.json();
            return { topBooks, readersCount };
        } catch (error) {
            return null;
        }
    };

    const fetchTopAuthorsAndUploadedBooks = async () => {
        try {
            const response = await fetch('/statistics/topAuthors');
            const { topAuthors, uploadCounts } = await response.json();
            return { topAuthors, uploadCounts };
        } catch (error) {
            return null;
        }
    };

    const renderBarChart = async () => {
        const barCtx = document.getElementById('bookChart').getContext('2d');
        const { topBooks, readersCount } = await fetchTopBooksAndReaders();

        const colors = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)'
        ];

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: topBooks,
                datasets: [{
                    label: 'Book Readers',
                    data: readersCount,
                    backgroundColor: colors.slice(0, topBooks.length),
                    borderColor: colors.map(color => color.replace('0.5', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Readers Count'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Titles'
                        }
                    }
                }
            }
        });
    };

    const renderPieChart = async () => {
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const { topAuthors, uploadCounts } = await fetchTopAuthorsAndUploadedBooks();

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: topAuthors,
                datasets: [{
                    label: 'Uploaded Books',
                    data: uploadCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    };

    if(fetchTopBooksAndReaders) { 
        renderBarChart();
    }

    if(fetchTopAuthorsAndUploadedBooks) {
        renderPieChart();
    }
});
