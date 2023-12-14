<?php
$conn = new mysqli('localhost', 'root', '', 'kampoeng_radjoet');
$query3 = $conn->query(
    "SELECT
        nama_produk as produk_keluar ,
        SUM(stok) as stok_keluar
        FROM barang_keluar
        GROUP BY produk_keluar
        "
);

foreach ($query3 as $stok_produk) {
    $name_product[] = $stok_produk['produk_keluar'];
    $stok[] = $stok_produk['stok_keluar'];
}
?>

<script>
    // start chart 3
    const label3 = <?php echo json_encode($name_product) ?>
    const data_stok = {
        labels: label3,
        datasets: [{
            label: 'Stok Keluar',
            data: <?php echo json_encode($stok)  ?>,
            backgroundColor: [
                '#9E41FB',
                '#C995FD',
                '#EAD6FE'
            ],
            hoverOffset: 8
        }]
    };

    const config3 = {
        type: 'doughnut',
        data: data_stok,
        options: {
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    var myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
    );
</script>