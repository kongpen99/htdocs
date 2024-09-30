// console.log(predate);
$("#tb-mtreport").dataTable({
    scrollX: true,
    scrollY: "400px",
    pageLength: 100,
    dom: "Bfrtip",
    // buttons: ["copy", "excel"],
    buttons: [
        'copyHtml5',
        {
            extend: 'excelHtml5',
            title: 'รายงานการบันทึกและประวัติการตรวจสอบPCB-NG'
        }
    ]
});


$("#reportPCB").dataTable({
    scrollX: true,
    scrollY: "400px",
    pageLength: 100,
    columnDefs: [{

            className: "dt-center",
            targets: [0, 1, 2, 3],
        },
        {
            className: "dt-left",
            targets: [4, 5],
        },
    ],
    dom: "Bfrtip",
    buttons: ["copy", "excel"],
});
$("#reportNGCASE").dataTable({
    scrollX: true,
    scrollY: "100vh",
    pageLength: 100,
    paging: false,
    dom: "Bfrtip",
    buttons: ["copy", "excel"],
    // fixedColumns: {
    //     left: 1
    // },
});
$("#reportLine").dataTable({
    scrollY: "50vh",
    pageLength: 100,
    columnDefs: [{
            className: "dt-center",
            targets: [0, 1, 2, 3, 4, 5],
        },
        {
            width: 100,
            targets: [0, 3, 4],
        },
        {
            width: 150,
            targets: [1, 5],
        },
        {
            width: 250,
            targets: [2],
        },


    ],
    dom: "Bfrtip",
    buttons: ["copy", "excel"],
});
$(document).ready(function() {
    showchart();
});

function random_rgba() {
    var o = Math.round,
        r = Math.random,
        s = 255;
    return "rgba(" + o(r() * s) + "," + o(r() * s) + "," + o(r() * s) + ")";
}

function showchart() {
    $.post(
        "data.php", {
            Previous: predate,
            Last: lastdate,
        },
        function(res) {
            console.log(res);
            let customer = [];
            let qty = [];
            let color = [];

            for (let i in res) {
                let index = customer.indexOf(res[i].HREC_CUS);

                if (index == -1) {
                    color.push(random_rgba());
                    customer.push(res[i].HREC_CUS);
                }
            }

            for (let i in customer) {
                //console.log(customer[i])
                let result = 0;
                for (let j in res) {
                    if (customer[i] == res[j].HREC_CUS) {
                        // result += res[j].HREC_QTY
                        result += 1;
                    }
                }
                qty.push(result);
            }

            console.log(customer);
            console.log(color);
            console.log(qty);
            let num = Math.max.apply(null, qty);
            let maxnum = num + 6;
            console.log(num);

            const data = {
                labels: customer,
                datasets: [{
                    backgroundColor: color,
                    data: qty,
                    borderWidth: 0,
                    borderColor: "rgba(255, 200, 255,0)",
                }, ],
            };

            // config
            const config = {
                type: "bar",
                data,
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                generateLabels: (chart) => {
                                    console.log(chart.data.datasets[0].borderColor);
                                    return chart.data.labels.map((label, index) => ({
                                        text: label,
                                        strokeStyle: chart.data.datasets[0].borderColor,
                                        fillStyle: chart.data.datasets[0].backgroundColor[index],
                                    }));
                                },
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                            max: maxnum,
                        },
                    },
                },
            };

            // render init block
            const myChart = new Chart(document.getElementById("myChart"), config);
        }
    );
}