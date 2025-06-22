// Toggle sidebar on mobile
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('mainContent').classList.toggle('active');
});

// Initialize chart
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('funnelChart').getContext('2d');
    const funnelChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Solar Starter', 'Premium Solar', 'Commercial Solar', 'Custom Package'],
            datasets: [
                {
                    label: 'Leads',
                    data: [320, 180, 150, 80],
                    backgroundColor: 'rgba(99, 102, 241, 0.7)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Conversions',
                    data: [45, 25, 30, 12],
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Funnels'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
