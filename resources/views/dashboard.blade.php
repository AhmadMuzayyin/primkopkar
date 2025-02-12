<x-app-layout>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <span class="badge badge-soft-primary float-end">Per Month</span>
                        <h5 class="card-title mb-0">Pertokoan</h5>
                    </div>
                    <div class="row d-flex align-items-center mb-4">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
                                {{ 'Rp.' . number_format($toko) }}
                            </h4>
                        </div>
                    </div>

                    <div class="progress shadow-sm" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div><!-- end card-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <span class="badge badge-soft-primary float-end">Per Month</span>
                        <h5 class="card-title mb-0">Simpanan</h5>
                    </div>
                    <div class="row d-flex align-items-center mb-4">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
                                {{ 'Rp.' . number_format($simpanan) }}
                            </h4>
                        </div>
                    </div>

                    <div class="progress shadow-sm" style="height: 5px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div><!-- end card-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <span class="badge badge-soft-primary float-end">Per Month</span>
                        <h5 class="card-title mb-0">Pinjaman</h5>
                    </div>
                    <div class="row d-flex align-items-center mb-4">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
                                {{ 'Rp.' . number_format($pinjaman) }}
                            </h4>
                        </div>
                    </div>

                    <div class="progress shadow-sm" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end card-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <span class="badge badge-soft-primary float-end">Per Month</span>
                        <h5 class="card-title mb-0">Jasa Angkutan</h5>
                    </div>
                    <div class="row d-flex align-items-center mb-4">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
                                {{ 'Rp.' . number_format($jasa) }}
                            </h4>
                        </div>
                    </div>

                    <div class="progress shadow-sm" style="height: 5px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div><!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline-block">Pendapatan Pertokoan</h4>
                    <div id="pertokoan" class="morris-chart" style="height: 290px;"></div>
                </div>
                <!--end card body-->

            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline-block">Pendapatan Simpanan</h4>

                    <div id="simpanan" class="morris-chart" style="height: 290px;"></div>
                </div>
                <!--end card body-->

            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline-block">Pendapatan Pinjaman</h4>

                    <div id="pinjaman" class="morris-chart" style="height: 290px;"></div>
                </div>
                <!--end card body-->

            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-inline-block">Pendapatan Jasa Angkutan</h4>

                    <div id="jasa" class="morris-chart" style="height: 290px;"></div>
                </div>
                <!--end card body-->

            </div>
            <!--end card-->
        </div>
        <!--end col-->

    </div>
    <!--end row-->
    @push('js')
        <script>
            var data = [{
                    y: "2024",
                    b: 100
                },
                {
                    y: "2025",
                    b: 130
                },
                {
                    y: "2026",
                    b: 110
                },
                {
                    y: "2027",
                    b: 140
                },
                {
                    y: "2028",
                    b: 140
                },
                {
                    y: "2029",
                    b: 125
                },
                {
                    y: "2030",
                    b: 190
                },
            ];
            // line chart Pertokoan
            $("#pertokoan").length && Morris.Line({
                element: "pertokoan",
                gridLineColor: "#20B799",
                lineColors: ["#20B799"],
                data: data,
                xkey: "y",
                ykeys: ["b"],
                hideHover: "auto",
                resize: true,
                labels: ["Total"]
            })
            // line chart pinjaman
            $("#pinjaman").length && Morris.Line({
                element: "pinjaman",
                gridLineColor: "#EFB540",
                lineColors: ["#EFB540"],
                data: data,
                xkey: "y",
                ykeys: ["b"],
                hideHover: "auto",
                resize: !0,
                labels: ["Total"]
            })
            // line chart Simpanan
            $("#simpanan").length && Morris.Line({
                element: "simpanan",
                gridLineColor: "#FA5944",
                lineColors: ["#FA5944"],
                data: data,
                xkey: "y",
                ykeys: ["b"],
                hideHover: "auto",
                resize: !0,
                labels: ["Total"]
            })
            // line chart Jasa Angkutan
            $("#jasa").length && Morris.Line({
                element: "jasa",
                gridLineColor: "#3CBADE",
                lineColors: ["#3CBADE"],
                data: data,
                xkey: "y",
                ykeys: ["b"],
                hideHover: "auto",
                resize: !0,
                labels: ["Total"]
            })
        </script>
    @endpush
</x-app-layout>
