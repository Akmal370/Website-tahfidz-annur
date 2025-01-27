<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
<!--begin::Container-->
<div class="container-xxl" id="form_ubah_web_profile">
    <!--begin::Basic primary-->
    <div class="w-100 card mb-5 mt-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0 d-flex justify-content-between align-items-center w-100">
                <h3 class="fw-bold m-0">Laporan Pembelian</h3>
            </div>
            <!--end::Card title-->
            
            
        </div>
    </div>

    <div class="card w-100 mb-5 py-5 px-5">
        <form class="d-flex fw-row w-100">
            <!--begin::Input group-->
            <div class="fv-row mb-7 col-md-5">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2">Tanggal Mulai</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="date" name="date_start" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $tanggal_mulai; ?>" placeholder="Masukkan Tanggal Mulai" autocomplete="off" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7 col-md-5">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2">Tanggal Selesai</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="date" name="date_end" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $tanggal_selesai; ?>" placeholder="Masukkan Tanggal Selesai" autocomplete="off" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            
        </form>
        
    </div>
    <div class="card w-100 mb-5">
        <div class="card-header py-5 px-5">
            <h3 class="text-primary">Tabel Donatur</h3>
        </div>
        <div class="card-body d-flex flex-wrap jsustify-content-between">
            <div class="col-md-12 fw-row d-flex">
                <div class="card-body pt-5">
                    <div class="w-100 mb-5 mb-xl-8" id="base_table" >
                        <!--begin::Table container-->
                        <form action="<?= base_url('setting_function/drag') ?>" method="POST" class="table-responsive" id="reload_table">
                            <div style="min-height : 200px;max-height : 400px">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" >
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="w-25px">No</th>
                                            <th class="min-w-100px">Tanggal</th>
                                            <th class="min-w-100px">Kode</th>
                                            <th class="min-w-100px">Nama</th>
                                            <th class="min-w-100px">Email</th>
                                            <th class="min-w-100px text-center">Nominal</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        <?php if ($result) : ?>
                                            <?php $no = ($offset  + 1); foreach ($result as $row) : $num = $no++; ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <?= $num;?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-primary"><?= $row->code ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted"><?= date('d M Y H:i',strtotime($row->create_date)); ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if($row->name) : ?>
                                                        <span class="text-muted"><?= $row->name; ?></span>
                                                        <?php else : ?>
                                                            <span class="text-danger">Member tidak terdaftar</span>
                                                        <?php endif;?>
                                                    </td>
                                                    <td>
                                                        <div class="text-muted text-center"><?= $row->email ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="text-muted text-center">Rp. <?= number_format($row->nominal,0,',','.') ?></div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6">
                                                    <center>Data Tidak Ditemukan</center>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <?= $this->pagination->create_links(); ?>
                        </form>
                        <!--end::Table container-->
                    </div>
                    
                </div>
                
            </div> 
        </div>
        
    </div>
    
    <div class="w-100 card mb-5 mt-5 mb-xl-8">
        <!--begin::Body-->
        <div class="d-flex flex-stack flex-wrap ms-10 mt-10">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start">
                <!--begin::Title-->
                <h1 class="d-flex text-primary fw-bold m-0 fs-3">Grafik Keuangan</h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <div class="card-body py-3" >
            <div id="keuangan" style="min-height : 500px; height : auto;"></div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("keuangan");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: true,
  panY: true,
  wheelX: "panX",
  wheelY: "zoomX",
  pinchZoomX: true,
  paddingLeft:0,
  paddingRight:1
}));

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, { 
  minGridDistance: 3000, 
  minorGridEnabled: true
});

xRenderer.labels.template.setAll({
//   rotation: -90,
//   centerY: am5.p50,
//   centerX: am5.p100,
//   paddingRight: 15
visible: false
});

xRenderer.grid.template.setAll({
  location: 1
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  maxDeviation: 0.3,
  categoryField: "tanggal",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

var yRenderer = am5xy.AxisRendererY.new(root, {
  strokeOpacity: 0.1
})

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  maxDeviation: 0.3,
  renderer: yRenderer
}));

// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "Series 1",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "value",
  sequencedInterpolation: true,
  categoryXField: "tanggal",
  tooltip: am5.Tooltip.new(root, {
    labelText: "Rp. {valueY}"
  })
}));

series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
series.columns.template.adapters.add("fill", function (fill, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});

series.columns.template.adapters.add("stroke", function (stroke, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});

<?php
    $arr2 = [];
    if ($keuangan) {
        $no = 0;
        foreach ($keuangan as $name => $value) {
            $num = $no++;
            $arr2[$num]['tanggal'] = date('d-M-Y',strtotime($name));
            $arr2[$num]['value'] = (int)$value;
        }
    }
    $arr2 = json_encode($arr2);
?>
// Set data
var data = <?= $arr2; ?>;

xAxis.data.setAll(data);
series.data.setAll(data);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear(1000);
chart.appear(1000, 100);

}); // end 
am5.ready()
</script>


