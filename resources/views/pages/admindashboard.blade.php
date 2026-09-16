@extends('layouts.master-admin')

@section('title', 'Dashboard')

@section('page-title', 'Papua New Guinea Crisis Management Tools')

@push('styles')


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #map {
            height: 700px;
        }
        .filter-container {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        /* === Facilities filter list (map panel) === */
        .facility-list {
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .facility-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 1px 6px;
            border-radius: 5px;
            transition: background-color .15s ease;
        }
        .facility-item:hover {
            background-color: #f4f7fb;
        }
        /* Bootstrap 4 (AdminLTE) sets .form-check-input to position:absolute with a
           negative left margin, which makes the box overlap the label text here. */
        .facility-item .form-check-input {
            position: static;
            float: none;
            flex: 0 0 15px;
            width: 15px;
            height: 15px;
            margin: 0;
            cursor: pointer;
        }
        .facility-item .form-check-label {
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin: 0;
            font-size: 13px;
            line-height: 18px;
            color: #333;
            cursor: pointer;
        }
        .facility-item .facility-name.is-all {
            font-weight: 600;
        }
        .facility-item .facility-count {
            flex: 0 0 auto;
            min-width: 26px;
            padding: 1px 6px;
            border-radius: 10px;
            background: #eef1f5;
            color: #555;
            font-size: 11px;
            line-height: 16px;
            font-weight: 600;
            text-align: center;
        }
        .facility-item .form-check-input:checked + .form-check-label .facility-count {
            background: #e2ecfa;
            color: #2b5f9e;
        }

        .form-check-scrollable {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }
        .total-info {
            background: white;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0,0,0,0.2);
            font-weight: bold;
            margin-left: 10px;
        }

        .select2-container .select2-selection--single {
            height: 45px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
            right: 10px;
        }

        .p-modal{
            text-align:justify;
        }
        .hospital-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0 5px;
        }
        .hospital-legend-item img {
            width: 30px;
            height: 30px;
        }

        p{
        margin-bottom: 8px;
            line-height: 18px;
        }

        .btn-danger{
            background-color:#395272;
            border-color: transparent;
        }

        .btn-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .btn.active {
            background-color: #5686c3 !important;
            border-color: transparent !important;
            color: #fff !important;
        }

        .p-3{
            padding: 10px !important;
            margin: 0 3px;
        }

        .btn-outline-danger{
            color: #FFFFFF;
            background-color:#395272;
            border-color: transparent;
        }

        .btn-outline-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .fa,
        .fab,
        .fad,
        .fal,
        .far,
        .fas {
            color: #346abb;
        }

        .card-header{
            padding: 0.25rem 1.25rem;
            color: #3c66b5;
            font-weight: bold;
        }

        .mb-4{
            margin-bottom: 0.5rem !important;
        }

    /* Classification section */
    .classification {
      display: flex;
      width: 100%;
    }

    .class-column {
      flex: 1;
      text-align: center;

    }
    .class-column:last-child {
      border-right: none;
    }

    .class-header {
      font-weight: 600;
      padding: 0.1rem 0;
    }

    /* Color bars */
    .class-medical-classification {border: none; text-align: center; text-transform: uppercase;}
    .class-airport-category {border: none; text-transform: uppercase;}
    .class-advanced { border-bottom: 3px solid #0070c0; }
    .class-intermediate { border-bottom: 3px solid #00b050; }
    .class-basic { border-bottom: 3px solid #ffc000; }

    /* Airport layout */
    .airport-list {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 0;
    }

    .airfield-classification,
    .airfield-classification .class-header,
    .airfield-classification .hospital-row,
    .airfield-classification .hospital-item {
      justify-content: flex-start;
      text-align: left;
    }

    .airfield-classification .hospital-item .btn:first-child {
      padding-left: 0 !important;
    }

    .dashboard-legend-groups {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 24px;
      width: 100%;
    }

    .airfield-classification {
      flex: 0 0 420px;
      margin-right: 0 !important;
    }

    .airfield-classification .airfield-row {
      display: grid;
      grid-template-columns: repeat(4, 100px);
      align-items: center;
      width: 100%;
    }

    .airfield-classification .airfield-row .btn {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 5px;
      width: 100%;
      min-height: 34px;
      padding-left: 0 !important;
      text-align: left;
      white-space: nowrap;
    }

    .airfield-classification .airfield-row img {
      flex: 0 0 18px;
      object-fit: contain;
    }

    .police-classification {
      display: block;
      flex: 0 0 410px;
      min-width: 410px;
      margin-left: 0 !important;
      text-align: left;
    }

    .police-classification-title {
      display: block;
      width: 100%;
      margin: 0 0 7px;
      padding: 0;
      line-height: 1.2;
      text-align: left;
      text-transform: uppercase;
      font-weight: 700 !important;
    }

    .police-classification-grid {
      display: grid;
      grid-template-columns: 160px 230px;
      column-gap: 10px;
      row-gap: 4px;
      width: 400px;
    }

    .police-classification-grid .btn {
      display: grid;
      grid-template-columns: 15px minmax(0, 1fr);
      align-items: start;
      gap: 6px;
      min-height: 36px;
      width: 100%;
      padding-left: 0 !important;
      text-align: left;
      white-space: normal;
    }

    .police-classification-grid img {
      margin-top: 2px;
      object-fit: contain;
    }

    @media (max-width: 1199.98px) {
      .dashboard-legend-groups { flex-wrap: wrap; }
      .police-classification { min-width: min(100%, 410px); }
    }

    .dashboard-menu-wrap {
      display: flex;
      justify-content: flex-end;
      width: 100%;
      padding: 1rem;
    }

    .dashboard-menu {
      display: flex;
      align-items: stretch;
      justify-content: space-between;
      gap: 6px;
      width: 100%;
      max-width: 360px;
      margin-top: 0.5rem;
    }

    .dashboard-menu .btn {
      display: flex;
      flex: 0 0 67px;
      min-width: 67px;
      min-height: 65px;
      margin: 0;
      padding: 10px 4px !important;
      align-items: center;
      justify-content: flex-start;
      text-align: center;
    }

    .dashboard-menu .btn small {
      line-height: 1.2;
    }

    /* Hospital layout */
    .hospital-list {
      display: flex;
      flex-direction: column;
      align-items: center;

    }

    /* For side-by-side classes */
    .hospital-row {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0;
    }

    .hospital-item {
      display: flex;
      align-items: center;
      gap: 0;
      font-size: 0.9rem;
      white-space: nowrap;
    }

    .hospital-icon {
      width: 18px;
      height: 18px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Image inside icon box */
    .hospital-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* Airfield icons */
    .category-item img {
      width: 16px;
      height: 16px;
      object-fit: contain;
    }

     .select-input {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 8px 10px;
        background: #fff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .select-input input {
        border: none;
        width: 100%;
        cursor: pointer;
        background: transparent;
        outline: none;
    }

    .select-dropdown {
        display: none;
        position: absolute;
        width: 100%;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-top: 3px;
        z-index: 9999;
        max-height: 250px;
        overflow: hidden;
    }

    .select-dropdown.show {
        display: block;
    }

    .dropdown-search {
        width: 100%;
        border: none;
        border-bottom: 1px solid #ddd;
        padding: 8px;
        outline: none;
    }

    #provinceList {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 180px;
        overflow-y: auto;
    }

    #provinceList li {
        padding: 5px 10px;
    }

    #provinceList li:hover {
        background: #f5f5f5;
    }

    #provinceList label {
        width: 100%;
        margin: 0;
        cursor: pointer;
    }

    .legend-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    width: 100%;
    align-items: start;
}

.legend-grid-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 6px;
    width: 100%;
    text-align: left;
    white-space: nowrap;
}

.legend-grid-item img {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
}

.legend-grid-item small {
    text-align: left;
}

/* ===== Google Places Autocomplete Fix ===== */
.pac-container {
    z-index: 99999 !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2) !important;
    font-family: inherit !important;
    margin-top: 2px !important;
    border: 1px solid #ddd !important;
}

.pac-item {
    padding: 6px 12px !important;
    cursor: pointer !important;
    font-size: 13px !important;
    border-top: 1px solid #f0f0f0 !important;
}

.pac-item:hover {
    background: #f0f6ff !important;
}

.pac-item-query {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #333 !important;
}

.pac-matched {
    color: #1a73e8 !important;
    font-weight: 700 !important;
}

#locationSearchMap:focus {
    outline: none !important;
    border-color: #1a73e8 !important;
    box-shadow: 0 0 0 2px rgba(26,115,232,0.2) !important;
}

/* === Info modal bertab (Polda / Polres / Polsek) ===
   Sama seperti di halaman Police. Lebarnya cukup untuk satu baris tab,
   tingginya mengikuti isi. CSS halaman ini Bootstrap 4 (AdminLTE), jadi
   lebar dialog harus di-override sendiri. */
.info-modal-dialog {
    max-width: 1180px;
    width: 95vw;
}
.info-modal-dialog .modal-content {
    max-height: 88vh;
    border: none;
    border-radius: 10px;
    overflow: hidden;
}
.info-modal-dialog .modal-header {
    flex: 0 0 auto;
    background: #f8f9fa;
}

.info-modal-tabs {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    flex: 0 0 auto;
    flex-wrap: nowrap;
    gap: 2px;
    overflow-x: auto;
}
.info-modal-tabs .nav-link {
    border: 1px solid transparent;
    border-bottom: none;
    border-radius: 6px 6px 0 0;
    color: #55606e;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 14px;
    white-space: nowrap;
}
.info-modal-tabs .nav-link:hover {
    background: #eef2f7;
    color: #395272;
}
.info-modal-tabs .nav-link.active {
    background: #fff;
    color: #395272;
    border-color: #dee2e6 #dee2e6 #fff;
}
.info-modal-body {
    padding: 0;
    overflow: hidden;
    flex: 1 1 auto;
    min-height: 0;
}
.info-modal-content {
    overflow-y: auto;
    padding: 18px 24px 24px 24px;
    min-height: 260px;
    max-height: calc(88vh - 120px);
}
.info-modal-content ul {
    padding-left: 20px;
    margin-bottom: 12px;
}
.info-modal-content ul li {
    margin-bottom: 6px;
    line-height: 20px;
    text-align: justify;
}
.info-modal-content ul ul {
    margin-top: 6px;
    margin-bottom: 4px;
    list-style-type: circle;
    padding-left: 20px;
}
.info-modal-content ul ul li {
    margin-bottom: 4px;
}
.info-modal-figure {
    margin-top: 14px;
    text-align: center;
}
.info-modal-figure img {
    display: inline-block;
    max-width: 100%;
    height: auto;
    border: 1px solid #e3e8ee;
    border-radius: 6px;
}
.info-modal-note {
    margin: 8px 0 4px 0;
    padding: 8px 12px;
    background: #f4f8fb;
    border-left: 3px solid #395272;
    border-radius: 4px;
    font-size: 12.5px;
    line-height: 19px;
    text-align: justify;
    color: #445060;
}

/* Tabel klasifikasi Polda (gaya biru bertingkat) */
.polda-class-table {
    width: 100%;
    margin: 4px 0 8px 0;
    border-collapse: collapse;
    font-size: 13px;
    line-height: 19px;
    color: #10333f;
}
.polda-class-table th,
.polda-class-table td {
    padding: 10px 12px;
    border: 1px solid #fff;
    text-align: justify;
    vertical-align: top;
}
.polda-class-table thead th {
    background: #1c7fa4;
    color: #fff;
    font-weight: 700;
    text-align: left;
    vertical-align: middle;
}
.polda-class-table tbody tr:nth-child(odd) td {
    background: #62c2dd;
}
.polda-class-table tbody tr:nth-child(even) td {
    background: #cbe7f4;
}

/* Tabel klasifikasi unit Polres & Polsek (kolom pertama navy, baris biru bertingkat) */
.unit-class-table {
    width: 100%;
    margin: 4px 0 8px 0;
    border-collapse: collapse;
    font-size: 13px;
    line-height: 19px;
    color: #10333f;
}
.unit-class-table th,
.unit-class-table td {
    padding: 10px 12px;
    border: 1px solid #fff;
    vertical-align: top;
}
.unit-class-table thead th {
    background: #14506a;
    color: #fff;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
.unit-class-table tbody th {
    background: #14506a;
    color: #fff;
    font-weight: 700;
    text-align: left;
}
.unit-class-table tbody tr:nth-child(odd) td {
    background: #83c9e5;
}
.unit-class-table tbody tr:nth-child(even) td {
    background: #cfe7f5;
}

</style>

@endpush

@section('conten')

<div class="card">
    <div class="row" style="background-color: #dfeaf1;">
           <div class="col-md-9">
            <div class="d-flex p-3 justify-content-start">
                <div class="dashboard-legend-groups">

                <!-- Airport -->
                      <div class="class-column airfield-classification" style="margin-right: 100px;">
                        <div class="class-header class-airport-category">Airfield Classification</div>
                        <div class="airport-list">
                          <div class="hospital-row" style="flex-direction: column;">
                            <!-- Airport row 1 -->
                            <div class="hospital-item airfield-row">
                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level6Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:18px; height:18px;">
                                  <small>International</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level5Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:18px; height:18px;">
                                  <small>Domestic</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level4Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:18px; height:18px;">
                                  <small>Regional</small>
                              </button>
                            </div>
                            <!-- Airport row 2 -->
                            <div class="hospital-item airfield-row">
                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level2Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:18px; height:18px;">
                                  <small>Civil-Military</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level3Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:18px; height:18px;">
                                  <small>Military</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level1Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:18px; height:18px;">
                                  <small>Private</small>
                              </button>

                               <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/11/helipad-removebg.png" style="width:18px; height:18px;">
                                  <small>Helipad</small>
                              </button>
                            </div>
                          </div>

                        </div>
                      </div>

                      <!-- Medical Facility Legend -->
                      <div style="flex-direction: column;">
                        <!-- Title -->
                        <div>
                            <div class="class-header class-medical-classification">Medical Facility Classification</div>
                        </div>
                        <div style="display: flex; flex-direction: row;">
                            <!-- Advanced -->
                            <div class="class-column">
                              <div class="class-header class-advanced">Advanced</div>
                              <div class="hospital-list">
                                <div class="hospital-item">
                                  <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                                    <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                                    <small>Tertiary</small>
                                  </button>
                                </div>
                              </div>
                            </div>

                            <!-- Intermediate -->
                            <div class="class-column">
                              <div class="class-header class-intermediate">Intermediate</div>
                              <div class="hospital-list">
                                <div class="hospital-row">
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                                      <small>Secondary</small>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Basic -->
                            <div class="class-column">
                              <div class="class-header class-basic">Basic</div>
                              <div class="hospital-list">
                                <div class="hospital-row">
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level33Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24px; height:24px;">
                                      <small>Primary</small>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <!-- Police Classification -->
                      <div class="police-classification">
                        <span class="fw-bold police-classification-title">Police Classification</span>
                        <div class="police-classification-grid">

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#nationalPoliceHqModal">
                          <img src="{{ asset('images/Layer1.png') }}" style="width:12px; height:12px;">
                          <small>National Police (HQ)</small>
                        </button>

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#policeDivisionsModal">
                          <img src="{{ asset('images/Layer2.png') }}" style="width:12px; height:12px;">
                          <small>Police Divisions (Land Divisions)</small>
                        </button>

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#neighbourhoodPoliceCentreModal">
                          <img src="{{ asset('images/Layer3.png') }}" style="width:12px; height:12px;">
                          <small>Neighbourhood Police Centre (NPC)</small>
                        </button>

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#neighbourhoodPolicePostModal">
                          <img src="{{ asset('images/Layer4.png') }}" style="width:12px; height:12px;">
                          <small>Neighbourhood Police Post (NPP)</small>
                        </button>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-menu-wrap">
                <div class="dashboard-menu">

                    <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                        <i class="bi bi-airplane fs-3"></i>
                        <small>Airports</small>
                    </a>

                    <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                    <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                        <small>Medical</small>
                    </a>

                    <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                        <img src="{{ asset('images/icon-air-charter.png') }}" style="width: 48px; height: 24px;">
                        <small>Air Charter</small>
                    </a>

                    <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                    <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                        <small>Police</small>
                    </a>

                    <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
                    <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                        <small>Embassies</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>


<div style="position:relative;">
<div id="map"></div>
<div id="routePanel" style="display:none;position:absolute;top:10px;left:10px;width:300px;max-height:calc(100% - 20px);background:#fff;border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,.18);z-index:999;flex-direction:column;overflow:hidden;font-family:inherit;">
  <div style="background:#1a73e8;padding:12px 14px;color:#fff;display:flex;justify-content:space-between;align-items:center;flex-shrink:0;"><div><div style="font-size:11px;opacity:.85;letter-spacing:.5px;">DRIVING DIRECTIONS</div><div id="routePanelTitle" style="font-size:13px;font-weight:600;margin-top:2px;">—</div></div><button type="button" onclick="closeRoutePanel()" aria-label="Close directions" style="background:rgba(255,255,255,.2);border:0;color:#fff;width:26px;height:26px;border-radius:50%;cursor:pointer;font-size:15px;">&times;</button></div>
  <div id="routeSummary" style="padding:10px 14px;background:#f0f4ff;border-bottom:1px solid #dde8ff;display:flex;gap:16px;flex-shrink:0;"><div style="text-align:center;"><div id="routeDistance" style="font-size:18px;font-weight:700;color:#1a73e8;">—</div><div style="font-size:10px;color:#666;text-transform:uppercase;">Distance</div></div><div style="text-align:center;"><div id="routeDuration" style="font-size:18px;font-weight:700;color:#395272;">—</div><div style="font-size:10px;color:#666;text-transform:uppercase;">Est. Time</div></div></div>
  <div id="routeSteps" style="overflow-y:auto;flex:1;padding:8px 0;"></div>
</div>
</div>

<div class="modal fade" id="level1Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Private Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Also known as private airfields or airstrips are primarily used for general and private aviation are owned by private individuals, groups, corporations, or organizations operated for their exclusive use that may include limited access for authorized personnel by the owner or manager. Owners are responsible to ensure safe operation, maintenance, repair, and control of who can use the facilities. Typically, they are not open to the public or provide scheduled commercial airline services and cater to private pilots, business aviation, and sometimes small charter operations. Services may be provided if authorized by the appropriate regulatory authority.</p>

        <p class="p-modal">A large majority of private airports are grass or dirt strip fields without services or facilities, they may feature amenities such as hangars, fueling facilities, maintenance services, and ground transportation options tailored to the needs of their owners or users. Private airports are not subject to the same level of regulatory oversight as public airports, but must still comply with applicable aviation regulations, safety standards, and environmental requirements. In the event of an emergency, landing at a private airport is authorized without any prior approval and should be done if landing anywhere else compromises the safety of the aircraft, crew, passengers, or cargo.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level2Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Combined Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Also called "joint-use airport," are used by both civilian and military aircraft, where a formal agreement exists between the military and a local government agency allowing shared access to infrastructure and facilities, typically with separate passenger terminals and designated operating areas, airspace allocation, and aircraft scheduling. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level3Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Military Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Facilities where military aircraft operate, also known as a military airport, airbase, or air station. Features include aircraft maintenance, air traffic control, communications, emergency response, fuel and weapon storage, defensive systems, aircraft shelters, and personnel facilities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level4Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Regional Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">A small or remote regional domestic airfield usually located in a geographically isolated area, far from major population centers, often with difficult terrain or vast distances from other airports with limited passenger traffic. May have shorter runways, basic facilities, and limited amenities, and basic infrastructure, serving primarily local communities providing access to essential services like medical transport or regional travel, rather than large-scale commercial flights.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level5Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Exclusively manages flights that originate and end within the same country, does not have international customs or border control facilities. Airport often has smaller and shorter runways, suitable for smaller regional aircraft used on domestic routes, and cannot support larger haul aircraft having less developed support services. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level6Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">International Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Meet standards set by the International Air Transport Association (IATA) and the International Civil Aviation Organization (ICAO), facilitate transnational travel managing flights between countries, have customs and border control facilities to manage passengers and cargo, and may have dedicated terminals for domestic and international flights. International airports have longer runways to accommodate larger, heavier aircraft, are often a main hub for air traffic, and can serve as a base for larger airlines. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level7Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Military Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Facilities where military aircraft operate, also known as a military airport, airbase, or air station. Features include aircraft maintenance, air traffic control, communications, emergency response, fuel and weapon storage, defensive systems, aircraft shelters, and personnel facilities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level33Modal" tabindex="-1" aria-labelledby="primaryPublicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered info-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="primaryPublicModalLabel">Primary Medical Facilities (Public)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<ul class="nav nav-tabs info-modal-tabs px-3 pt-2" role="tablist" aria-label="Primary medical facility information">
<li class="nav-item" role="presentation"><button class="nav-link active" id="primary-public-overview-tab" data-bs-toggle="tab" data-bs-target="#primary-public-overview" type="button" role="tab" aria-controls="primary-public-overview" aria-selected="true">Overview</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="primary-public-role-tab" data-bs-toggle="tab" data-bs-target="#primary-public-role" type="button" role="tab" aria-controls="primary-public-role" aria-selected="false">Role</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="primary-public-clinical-tab" data-bs-toggle="tab" data-bs-target="#primary-public-clinical" type="button" role="tab" aria-controls="primary-public-clinical" aria-selected="false">Clinical Services</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="primary-public-government-tab" data-bs-toggle="tab" data-bs-target="#primary-public-government" type="button" role="tab" aria-controls="primary-public-government" aria-selected="false">Government Healthcare System</button></li>
</ul>
<div class="modal-body info-modal-body">
<div class="tab-content info-modal-content">
<div class="tab-pane fade" id="primary-public-government" role="tabpanel" aria-labelledby="primary-public-government-tab" tabindex="0">
<p class="p-modal">Singapore operates a mixed public-private healthcare system under national regulation and government stewardship. The Ministry of Health sets policy, regulates healthcare services, plans capacity, administers subsidies and financing schemes, and oversees the public healthcare system. Public services are managed through three integrated clusters: National University Health System, NHG Health, and SingHealth. Each cluster links primary, secondary, tertiary, intermediate, community, and long-term care. [4][20]</p>
<p class="p-modal">For clinical and referral analysis, Singapore can be described through three principal levels: primary care, secondary care, and tertiary care. This three-level framework does not replace the Healthcare Services Act licensing framework, which licenses the service delivered rather than assigning a numerical or care-level grade to each institution.</p>
<h6 class="font-weight-bold mt-3">Key Facts</h6>
<ul>
<li><strong>System model:</strong> Mixed public-private healthcare with government regulation, public financing support, and public-cluster service delivery</li>
<li><strong>Lead authority:</strong> Ministry of Health, Singapore</li>
<li><strong>Principal care levels:</strong> Primary, secondary, and tertiary care</li>
<li><strong>Formal licensing framework:</strong> Service-based regulation under the Healthcare Services Act</li>
<li><strong>Public organisation:</strong> Three integrated clusters - National University Health System, NHG Health, and SingHealth</li>
<li><strong>Tertiary general hospitals:</strong> Singapore General Hospital, Tan Tock Seng Hospital, and National University Hospital</li>
<li><strong>Specialist tertiary hospitals:</strong> KK Women&#x27;s and Children&#x27;s Hospital and the Institute of Mental Health</li>
<li><strong>Secondary / regional general hospitals:</strong> Changi General Hospital, Khoo Teck Puat Hospital, Ng Teng Fong General Hospital, Sengkang General Hospital, Woodlands Hospital, and Alexandra Hospital</li>
<li><strong>Public primary care:</strong> 28 polyclinics as at the end of February 2026</li>
<li><strong>Intermediate inpatient care:</strong> Community hospitals provide post-acute, subacute, convalescent, and rehabilitative services outside the three principal acute-care levels</li>
<li><strong>Financing framework:</strong> Government subsidies, MediSave, MediShield Life, and MediFund</li>
<li><strong>Emergency medical access:</strong> SCDF 24-hour Emergency Medical Services through 995 for life-threatening emergencies</li>
<li><strong>Digital health:</strong> HealthHub and the National Electronic Health Record support access and care coordination</li>
</ul>
</div>
<div class="tab-pane fade show active" id="primary-public-overview" role="tabpanel" aria-labelledby="primary-public-overview-tab" tabindex="0">
<p class="p-modal">Public polyclinics form Singapore&#x27;s government-operated primary-care network. They are a major first point of contact for common acute illness, chronic-disease management, prevention, vaccination, screening, maternal-child services, allied health, and care coordination. Singapore had 28 polyclinics at the end of February 2026, organised under the three public healthcare clusters.</p>
<p class="info-modal-note">Note: Primary care is a level of care, not a hospital class. Polyclinics are outpatient facilities and do not normally operate hospital inpatient wards, major operating theatres, or intensive-care units. Private general-practitioner clinics, CHAS clinics, Family Medicine Clinics, and Primary Care Networks are important parts of the national primary-care system but are not public polyclinics. Primary Medical Facilities include public polyclinics, GP clinics, Family Medicine Clinics, Primary Care Networks, and Community Health Centers. They provide first-contact outpatient care, preventive services, screening, vaccination, chronic-disease management, minor treatment, diagnostics, and referrals.</p>
<div class="info-modal-note"><strong>Disclaimer</strong>
<p class="p-modal">The medical facility classifications in this document organize Singapore’s medical facilities according to the facility types identified by the Ministry of Health, their clinical capability, referral role, and position in the patient-care pathway.</p>
<p><a href="https://www.moh.gov.sg/seeking-healthcare/getting-medical-help/" target="_blank" rel="noopener noreferrer">Singapore Ministry of Health</a></p></div>
</div>
<div class="tab-pane fade" id="primary-public-role" role="tabpanel" aria-labelledby="primary-public-role-tab" tabindex="0">
<ul>
<li>Provide first-contact assessment and treatment for common acute and uncomplicated conditions</li>
<li>Manage diabetes, hypertension, hyperlipidaemia, and other chronic conditions, including Healthier SG follow-up</li>
<li>Deliver prevention, screening, vaccination, childhood development, maternal-child, and health-education services</li>
<li>Coordinate medication management, allied-health care, and referrals</li>
<li>Direct emergency or unstable patients to an emergency department or urgent-care service</li>
<li>Refer patients requiring specialist assessment, advanced diagnostics, surgery, or hospital admission</li>
</ul>
</div>
<div class="tab-pane fade" id="primary-public-clinical" role="tabpanel" aria-labelledby="primary-public-clinical-tab" tabindex="0">
<h6 class="font-weight-bold mt-3">Bed Capacity: No regular inpatient hospital beds</h6>
<h6 class="font-weight-bold mt-3">Core Services</h6>
<ul>
<li>General medical consultation and treatment of mild acute illness</li>
<li>Chronic-disease management, medication review, and long-term monitoring</li>
<li>Childhood immunisation, growth monitoring, and developmental assessment</li>
<li>Adult vaccination, preventive screening, and health counselling</li>
<li>Women&#x27;s health, maternal-child, mental-health, and geriatric services at designated sites</li>
<li>Dental, pharmacy, diagnostic, rehabilitation, dietetic, psychology, and other allied-health services according to site</li>
</ul>
<h6 class="font-weight-bold mt-3">Surgical &amp; Procedural Capacity</h6>
<ul>
<li>Wound care, dressing, injections, specimen collection, electrocardiography, and basic outpatient procedures</li>
<li>Minor procedures and treatment according to staff, equipment, licence, and site capability</li>
<li>No major surgery, intensive care, or full inpatient function</li>
<li>Immediate assessment, stabilisation, and transfer for severe illness, major trauma, obstetric emergency, or other hospital-level conditions</li>
</ul>
<h6 class="font-weight-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
<ul>
<li>Consultation, treatment, vaccination, screening, and chronic-care areas</li>
<li>Pharmacy and medication-dispensing services</li>
<li>Phlebotomy, basic laboratory testing, and diagnostic services according to site</li>
<li>Dental, radiology, rehabilitation, and allied-health services at designated polyclinics</li>
<li>Electronic records, HealthHub services, and referral links with public hospitals and specialty centers</li>
</ul>
<p class="info-modal-note">Note: The 28-polyclinic count is current to the end of February 2026. The Ministry of Health plans to expand the network to 32 polyclinics by 2030. Facility availability and service packages may change as new polyclinics open and existing sites are redeveloped.</p>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="level55Modal" tabindex="-1" aria-labelledby="secondaryPublicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered info-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="secondaryPublicModalLabel">Secondary Medical Facilities (Public)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<ul class="nav nav-tabs info-modal-tabs px-3 pt-2" role="tablist" aria-label="Secondary medical facility information">
<li class="nav-item" role="presentation"><button class="nav-link active" id="secondary-public-overview-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-overview" type="button" role="tab" aria-controls="secondary-public-overview" aria-selected="true">Overview</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="secondary-public-role-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-role" type="button" role="tab" aria-controls="secondary-public-role" aria-selected="false">Role</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="secondary-public-clinical-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-clinical" type="button" role="tab" aria-controls="secondary-public-clinical" aria-selected="false">Clinical Services</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="secondary-public-government-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-government" type="button" role="tab" aria-controls="secondary-public-government" aria-selected="false">Government Healthcare System</button></li>
</ul>
<div class="modal-body info-modal-body">
<div class="tab-content info-modal-content">
<div class="tab-pane fade" id="secondary-public-government" role="tabpanel" aria-labelledby="secondary-public-government-tab" tabindex="0">
<p class="p-modal">Singapore operates a mixed public-private healthcare system under national regulation and government stewardship. The Ministry of Health sets policy, regulates healthcare services, plans capacity, administers subsidies and financing schemes, and oversees the public healthcare system. Public services are managed through three integrated clusters: National University Health System, NHG Health, and SingHealth. Each cluster links primary, secondary, tertiary, intermediate, community, and long-term care. [4][20]</p>
<p class="p-modal">For clinical and referral analysis, Singapore can be described through three principal levels: primary care, secondary care, and tertiary care. This three-level framework does not replace the Healthcare Services Act licensing framework, which licenses the service delivered rather than assigning a numerical or care-level grade to each institution.</p>
<h6 class="font-weight-bold mt-3">Key Facts</h6>
<ul>
<li><strong>System model:</strong> Mixed public-private healthcare with government regulation, public financing support, and public-cluster service delivery</li>
<li><strong>Lead authority:</strong> Ministry of Health, Singapore</li>
<li><strong>Principal care levels:</strong> Primary, secondary, and tertiary care</li>
<li><strong>Formal licensing framework:</strong> Service-based regulation under the Healthcare Services Act</li>
<li><strong>Public organisation:</strong> Three integrated clusters - National University Health System, NHG Health, and SingHealth</li>
<li><strong>Tertiary general hospitals:</strong> Singapore General Hospital, Tan Tock Seng Hospital, and National University Hospital</li>
<li><strong>Specialist tertiary hospitals:</strong> KK Women&#x27;s and Children&#x27;s Hospital and the Institute of Mental Health</li>
<li><strong>Secondary / regional general hospitals:</strong> Changi General Hospital, Khoo Teck Puat Hospital, Ng Teng Fong General Hospital, Sengkang General Hospital, Woodlands Hospital, and Alexandra Hospital</li>
<li><strong>Public primary care:</strong> 28 polyclinics as at the end of February 2026</li>
<li><strong>Intermediate inpatient care:</strong> Community hospitals provide post-acute, subacute, convalescent, and rehabilitative services outside the three principal acute-care levels</li>
<li><strong>Financing framework:</strong> Government subsidies, MediSave, MediShield Life, and MediFund</li>
<li><strong>Emergency medical access:</strong> SCDF 24-hour Emergency Medical Services through 995 for life-threatening emergencies</li>
<li><strong>Digital health:</strong> HealthHub and the National Electronic Health Record support access and care coordination</li>
</ul>
</div>
<div class="tab-pane fade show active" id="secondary-public-overview" role="tabpanel" aria-labelledby="secondary-public-overview-tab" tabindex="0">
<p class="p-modal">Secondary medical facilities are public regional and general hospitals that provide hospital-level emergency, inpatient, surgical, medical, diagnostic, and specialist care beyond primary-care capability. They manage common and moderately complex conditions, serve defined population catchments, stabilise critically ill patients, and refer highly complex or national-subspecialty cases to a tertiary hospital or national specialty center.</p>
<p class="info-modal-note">Note: The Ministry of Health commonly distinguishes central tertiary hospitals from regional hospitals, but it does not publish a universal statutory list grading every public hospital as secondary or tertiary. The secondary grouping below is a functional classification of the remaining public acute general hospitals. Secondary Medical Facilities consist mainly of regional and general acute hospitals providing emergency care, inpatient treatment, general medicine, surgery, intensive care, diagnostics, and specialist outpatient services. Examples include Alexandra Hospital, Ng Teng Fong General Hospital, Khoo Teck Puat Hospital, Sengkang General Hospital, and Woodlands Hospital.</p>
<div class="info-modal-note"><strong>Disclaimer</strong>
<p class="p-modal">The medical facility classifications in this document organize Singapore’s medical facilities according to the facility types identified by the Ministry of Health, their clinical capability, referral role, and position in the patient-care pathway.</p>
<p><a href="https://www.moh.gov.sg/seeking-healthcare/getting-medical-help/" target="_blank" rel="noopener noreferrer">Singapore Ministry of Health</a></p></div>
</div>
<div class="tab-pane fade" id="secondary-public-role" role="tabpanel" aria-labelledby="secondary-public-role-tab" tabindex="0">
<ul>
<li>The principal general hospital for a regional population catchment</li>
<li>Receive patients from polyclinics, general practitioners, ambulance services, urgent-care services, and direct emergency presentation</li>
<li>Manage common and moderately complex medical, surgical, orthopaedic, geriatric, and emergency conditions</li>
<li>Provide admission, observation, specialist outpatient care, diagnostic services, day treatment, and rehabilitation coordination</li>
<li>Stabilise critical or highly complex patients before tertiary transfer</li>
<li>Receive patients returned from tertiary care and coordinate continued management with primary and community services</li>
</ul>
</div>
<div class="tab-pane fade" id="secondary-public-clinical" role="tabpanel" aria-labelledby="secondary-public-clinical-tab" tabindex="0">
<h6 class="font-weight-bold mt-3">Bed Capacity: Approximately 300 – 1000 beds</h6>
<p class="info-modal-note">Note: Bed capacity does not independently determine whether a hospital functions at secondary or tertiary level.</p>
<h6 class="font-weight-bold mt-3">Core Specialties</h6>
<ul>
<li>General and acute internal medicine</li>
<li>General surgery and selected surgical subspecialties</li>
<li>Emergency medicine and acute assessment, except where an alternative urgent-care model applies</li>
<li>Orthopaedics, geriatrics, anaesthesia, radiology, pathology, pharmacy, and rehabilitation</li>
<li>Cardiology, neurology, renal medicine, respiratory medicine, gastroenterology, infectious diseases, psychiatry, and other specialties according to institution</li>
<li>Obstetric, gynaecological, paediatric, or other services where provided by the institution or through referral arrangements</li>
</ul>
<h6 class="font-weight-bold mt-3">Intermediate Services</h6>
<ul>
<li>Twenty-four-hour emergency assessment, inpatient care, and stabilisation at general hospitals with emergency departments</li>
<li>Specialist outpatient clinics, day treatment, ambulatory procedures, and pre-admission services</li>
<li>Intensive care, high-dependency care, peri-operative care, and short-stay treatment according to hospital capability</li>
<li>Hospital-at-home, transitional-care, rehabilitation, medical social work, pharmacy, and allied-health services</li>
<li>Clinical coordination with tertiary hospitals, national specialty centers, community hospitals, and primary care</li>
</ul>
<h6 class="font-weight-bold mt-3">Surgical &amp; Procedural Capacity</h6>
<ul>
<li>Common elective and emergency surgery within the hospital&#x27;s approved capability</li>
<li>General, orthopaedic, urological, vascular, endoscopic, minimally invasive, and other procedures according to institution</li>
<li>Anaesthesia, operating-theatre, recovery, and post-operative monitoring</li>
<li>Day surgery, interventional procedures, and short-stay treatment</li>
<li>Stabilisation and transfer of cases requiring national-subspecialty surgery, highly complex intervention, transplantation, or prolonged tertiary intensive care</li>
</ul>
<h6 class="font-weight-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
<ul>
<li>Hospital laboratory, pathology, blood-bank, and transfusion support</li>
<li>General and advanced radiology, CT, MRI, ultrasound, endoscopy, and other diagnostics according to institution</li>
<li>Emergency, ward, theatre, recovery, critical-care, pharmacy, and infection-control infrastructure</li>
<li>Physiotherapy, occupational therapy, speech therapy, dietetics, psychology, and medical social-work services</li>
<li>Integrated electronic records and referral communication across the public healthcare cluster</li>
</ul>
<p class="info-modal-note">Note: Community Hospitals</p>
<p class="p-modal">Community hospitals are intermediate inpatient facilities that provide post-acute, subacute, convalescent, and rehabilitative care after stabilisation at an acute hospital. They support recovery and transition to home, residential care, or long-term services. They should not be treated as a fourth level beside primary, secondary, and tertiary care, and they are not equivalent to secondary acute hospitals.</p>
<h6 class="font-weight-bold mt-3">Public Community Hospitals / Services</h6>
<ul>
<li>Bright Vision Hospital - SingHealth</li>
<li>Jurong Community Hospital - National University Health System</li>
<li>Yishun Community Hospital - NHG Health</li>
<li>Sengkang Community Hospital - SingHealth Community Hospitals</li>
<li>Outram Community Hospital - SingHealth Community Hospitals</li>
<li>Woodlands Hospital community-hospital service - NHG Health</li>
</ul>
<h6 class="font-weight-bold mt-3">Government-Funded Not-for-Profit Community Hospitals</h6>
<ul>
<li>Ang Mo Kio - Thye Hua Kwan Hospital</li>
<li>Ren Ci Community Hospital</li>
<li>St Andrew&#x27;s Community Hospital</li>
<li>St Luke&#x27;s Hospital</li>
</ul>
<p class="p-modal">Community hospitals are licensed under Community Hospital Service and normally receive medically stable patients from acute hospitals. They do not usually provide major emergency surgery or full acute-hospital capability.</p>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="level66Modal" tabindex="-1" aria-labelledby="tertiaryPublicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered info-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="tertiaryPublicModalLabel">Tertiary Medical Facilities (Public)</h5>
        </div>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<ul class="nav nav-tabs info-modal-tabs px-3 pt-2" role="tablist" aria-label="Tertiary medical facility information">
<li class="nav-item" role="presentation"><button class="nav-link active" id="tertiary-public-overview-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-overview" type="button" role="tab" aria-controls="tertiary-public-overview" aria-selected="true">Overview</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="tertiary-public-role-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-role" type="button" role="tab" aria-controls="tertiary-public-role" aria-selected="false">Role</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="tertiary-public-clinical-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-clinical" type="button" role="tab" aria-controls="tertiary-public-clinical" aria-selected="false">Clinical Services</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="tertiary-public-government-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-government" type="button" role="tab" aria-controls="tertiary-public-government" aria-selected="false">Government Healthcare System</button></li>
</ul>
<div class="modal-body info-modal-body">
<div class="tab-content info-modal-content">
<div class="tab-pane fade" id="tertiary-public-government" role="tabpanel" aria-labelledby="tertiary-public-government-tab" tabindex="0">
<p class="p-modal">Singapore operates a mixed public-private healthcare system under national regulation and government stewardship. The Ministry of Health sets policy, regulates healthcare services, plans capacity, administers subsidies and financing schemes, and oversees the public healthcare system. Public services are managed through three integrated clusters: National University Health System, NHG Health, and SingHealth. Each cluster links primary, secondary, tertiary, intermediate, community, and long-term care. [4][20]</p>
<p class="p-modal">For clinical and referral analysis, Singapore can be described through three principal levels: primary care, secondary care, and tertiary care. This three-level framework does not replace the Healthcare Services Act licensing framework, which licenses the service delivered rather than assigning a numerical or care-level grade to each institution.</p>
<h6 class="font-weight-bold mt-3">Key Facts</h6>
<ul>
<li><strong>System model:</strong> Mixed public-private healthcare with government regulation, public financing support, and public-cluster service delivery</li>
<li><strong>Lead authority:</strong> Ministry of Health, Singapore</li>
<li><strong>Principal care levels:</strong> Primary, secondary, and tertiary care</li>
<li><strong>Formal licensing framework:</strong> Service-based regulation under the Healthcare Services Act</li>
<li><strong>Public organisation:</strong> Three integrated clusters - National University Health System, NHG Health, and SingHealth</li>
<li><strong>Tertiary general hospitals:</strong> Singapore General Hospital, Tan Tock Seng Hospital, and National University Hospital</li>
<li><strong>Specialist tertiary hospitals:</strong> KK Women&#x27;s and Children&#x27;s Hospital and the Institute of Mental Health</li>
<li><strong>Secondary / regional general hospitals:</strong> Changi General Hospital, Khoo Teck Puat Hospital, Ng Teng Fong General Hospital, Sengkang General Hospital, Woodlands Hospital, and Alexandra Hospital</li>
<li><strong>Public primary care:</strong> 28 polyclinics as at the end of February 2026</li>
<li><strong>Intermediate inpatient care:</strong> Community hospitals provide post-acute, subacute, convalescent, and rehabilitative services outside the three principal acute-care levels</li>
<li><strong>Financing framework:</strong> Government subsidies, MediSave, MediShield Life, and MediFund</li>
<li><strong>Emergency medical access:</strong> SCDF 24-hour Emergency Medical Services through 995 for life-threatening emergencies</li>
<li><strong>Digital health:</strong> HealthHub and the National Electronic Health Record support access and care coordination</li>
</ul>
</div>
<div class="tab-pane fade show active" id="tertiary-public-overview" role="tabpanel" aria-labelledby="tertiary-public-overview-tab" tabindex="0">
<p class="p-modal">Tertiary medical facilities form Singapore&#x27;s highest clinical referral level. They manage complex, severe, high-risk, rare, and subspecialty conditions that require advanced multidisciplinary care, specialised technology, intensive support, or national expertise. Singapore&#x27;s tertiary network comprises major tertiary general hospitals, dedicated tertiary specialist hospitals, and national specialty centers.</p>
<p class="info-modal-note">Note: Singapore does not operate a statutory hospital grading system that licenses institutions as Primary, Secondary, or Tertiary hospitals. The Healthcare Services Act applies service-based licences, including Acute Hospital Service, Community Hospital Service, and Outpatient Medical Service. Tertiary Medical Facilities include major referral hospitals, university hospitals, specialist hospitals, and national specialty centers providing complex, subspecialist, critical-care, teaching, research, and national referral services. Examples include Singapore General Hospital, National University Hospital, Tan Tock Seng Hospital, KK Women’s and Children’s Hospital, the Institute of Mental Health, and the national cancer, heart, neuroscience, eye, dental, skin, and infectious-disease centers.</p>
<div class="info-modal-note"><strong>Disclaimer</strong>
<p class="p-modal">The medical facility classifications in this document organize Singapore’s medical facilities according to the facility types identified by the Ministry of Health, their clinical capability, referral role, and position in the patient-care pathway.</p>
<p><a href="https://www.moh.gov.sg/seeking-healthcare/getting-medical-help/" target="_blank" rel="noopener noreferrer">Singapore Ministry of Health</a></p></div>
</div>
<div class="tab-pane fade" id="tertiary-public-role" role="tabpanel" aria-labelledby="tertiary-public-role-tab" tabindex="0">
<ul>
<li>The national or major referral level for complex, severe, rare, and high-risk cases</li>
<li>Receive referrals from regional general hospitals, specialist clinics, polyclinics, general practitioners, emergency services, and other healthcare institutions</li>
<li>Provide advanced medical, surgical, psychiatric, obstetric, paediatric, diagnostic, intensive-care, and subspecialty services</li>
<li>Coordinate multidisciplinary treatment involving multiple specialties, national centers, rehabilitation, and long-term follow-up</li>
<li>Support undergraduate, postgraduate, nursing, allied-health, specialist, and subspecialist training</li>
<li>Lead clinical research, national programmes, professional standards, and advanced service development</li>
</ul>
</div>
<div class="tab-pane fade" id="tertiary-public-clinical" role="tabpanel" aria-labelledby="tertiary-public-clinical-tab" tabindex="0">
<h6 class="font-weight-bold mt-3">Bed Capacity: Approximately above 850 beds</h6>
<p class="info-modal-note">Note: Bed capacity does not independently determine whether a hospital functions at secondary or tertiary level.</p>
<h6 class="font-weight-bold mt-3">Main Public Tertiary General Hospitals</h6>
<ul>
<li>Singapore General Hospital (SGH) - SingHealth; Singapore&#x27;s largest acute tertiary hospital</li>
<li>Tan Tock Seng Hospital (TTSH) - NHG Health; identified by the Ministry of Health as a central tertiary hospital</li>
<li>National University Hospital (NUH) - National University Health System; university hospital and major tertiary referral institution</li>
</ul>
<h6 class="font-weight-bold mt-3">Specialist Tertiary Hospitals</h6>
<ul>
<li>KK Women&#x27;s and Children&#x27;s Hospital (KKH) - SingHealth; tertiary referral care for high-risk women and children</li>
<li>Institute of Mental Health (IMH) - NHG Health; Singapore&#x27;s national acute tertiary psychiatric hospital</li>
</ul>
<h6 class="font-weight-bold mt-3">National Specialty Centers</h6>
<ul>
<li>National Cancer Center Singapore (NCCS) - SingHealth</li>
<li>National University Cancer Institute, Singapore (NCIS) - National University Health System</li>
<li>National Heart Center Singapore (NHCS) - SingHealth</li>
<li>National University Heart Center, Singapore (NUHCS) - National University Health System</li>
<li>Singapore National Eye Center (SNEC) - SingHealth</li>
<li>National Skin Center (NSC) - NHG Health</li>
<li>National Neuroscience Institute (NNI) - SingHealth</li>
<li>National Center for Infectious Diseases (NCID) - NHG Health</li>
<li>National Dental Center Singapore (NDCS) - SingHealth</li>
<li>National University Center for Oral Health Singapore (NUCOHS) - National University Health System</li>
</ul>
<h6 class="font-weight-bold mt-3">Core Specialties</h6>
<ul>
<li>Advanced internal medicine and medical subspecialties</li>
<li>Complex general surgery and surgical subspecialties</li>
<li>Cardiology, cardiothoracic surgery, oncology, neuroscience, neurosurgery, transplant medicine, and other high-complexity services</li>
<li>High-risk obstetrics, maternal-fetal medicine, neonatology, paediatric subspecialties, and specialised women&#x27;s health services</li>
<li>Tertiary psychiatric assessment, inpatient treatment, rehabilitation, addiction services, and national mental-health programmes</li>
<li>National specialist services for cancer, cardiac, eye, skin, neuroscience, infectious diseases, and oral healthcare</li>
</ul>
<h6 class="font-weight-bold mt-3">Intermediate Services</h6>
<ul>
<li>Twenty-four-hour emergency, inpatient, and critical-care services at tertiary hospitals according to institutional scope</li>
<li>Specialist and subspecialist outpatient clinics, day treatment, multidisciplinary case review, and long-term surveillance</li>
<li>Medical, surgical, coronary, neonatal, paediatric, neurological, psychiatric, and other intensive or high-dependency care</li>
<li>Pharmacy, blood services, medical social work, rehabilitation, psychology, dietetics, and specialist nursing support</li>
<li>National consultation, shared-care, outreach, and referral support for regional hospitals and primary care</li>
</ul>
<h6 class="font-weight-bold mt-3">Surgical &amp; Procedural Capacity</h6>
<ul>
<li>Major elective, emergency, complex, and subspecialty surgery</li>
<li>Advanced anaesthesia, peri-operative medicine, post-operative critical care, and multidisciplinary rehabilitation</li>
<li>Cardiac, neurological, transplant, cancer, paediatric, obstetric, orthopaedic, reconstructive, dental, and other specialist procedures according to institution</li>
<li>Minimally invasive surgery, robotic surgery, endoscopy, catheter-based intervention, interventional radiology, radiotherapy, and other advanced treatment</li>
<li>Access to host-hospital operating theatres and inpatient support for national specialty centers that do not operate a complete independent hospital platform</li>
</ul>
<h6 class="font-weight-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
<ul>
<li>Advanced radiology and imaging, including CT, MRI, ultrasound, fluoroscopy, nuclear medicine, and interventional imaging according to institution</li>
<li>Comprehensive clinical laboratory, pathology, microbiology, molecular testing, blood-bank, and transfusion support</li>
<li>Critical-care monitoring, ventilatory support, isolation capability, specialist procedural suites, and advanced life-support systems</li>
<li>Operating theatres, recovery areas, sterile-supply services, infection-prevention systems, pharmacy, and medication-management infrastructure</li>
<li>Clinical registries, research platforms, teaching facilities, multidisciplinary conference systems, and integrated electronic records</li>
</ul>
<p class="info-modal-note">Note: The Ministry of Health expressly identified TTSH, SGH, and NUH as central tertiary hospitals in a 2023 parliamentary response. KKH and IMH describe themselves as tertiary specialist referral institutions. National specialty centers are included under tertiary care because they provide national or highly specialised referral services, although they are not a separate hospital level.</p>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="nationalPoliceHqModal" tabindex="-1" aria-labelledby="nationalPoliceHqModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer1.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="nationalPoliceHqModalLabel">National Police (HQ)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> National police commander</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Commissioner of Police (CP)</p>
        <p class="p-modal"><strong>Role:</strong> Highest commander of SPF</p>
        <p class="p-modal">The CP is the Chief Executive and professional head of the SPF. The Commissioner exercises overall command of the Force, provides strategic leadership, formulates policing policies, directs nationwide operations, and advises the Government and the Ministry of Home Affairs on policing and internal security matters.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise overall command and control of the SPF.</li>
          <li>Formulate strategic policing priorities aligned with national security objectives.</li>
          <li>Provide leadership for all operational, investigative, intelligence, administrative, and support functions.</li>
          <li>Advise the Minister for Home Affairs on policing, crime prevention, and public safety policies.</li>
          <li>Direct national responses to major criminal incidents, terrorism, civil emergencies, and public order events.</li>
          <li>Ensure effective coordination with other Home Team agencies and international law enforcement organizations.</li>
          <li>Oversee organizational governance, integrity, professional standards, and institutional accountability.</li>
          <li>Lead organizational modernization through technological innovation, digital transformation, and capability development.</li>
          <li>Represent the SPF in domestic, regional, and international policing forums.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="policeDivisionsModal" tabindex="-1" aria-labelledby="policeDivisionsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer2.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="policeDivisionsModalLabel">Police Divisions (Land Divisions)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> Top territorial police command</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Assistant Commissioner of Police (AC Level)</p>
        <p class="p-modal">The <strong>Land Divisions</strong> represent the highest territorial command level within the SPF and serve as the principal operational formations responsible for delivering frontline policing services across Singapore. Each division is typically commanded by an <strong>Assistant Commissioner of Police (AC)</strong> and supervises a network of Neighborhood Police Centers and Neighborhood Police Posts that provide localized policing within residential, commercial, industrial, and civic communities. The seven (7) Land Divisions&mdash;<strong>Central (A), Clementi (D), Tanglin (E), Ang Mo Kio (F), Bedok (G), Jurong (J), and Woodlands (L)</strong>&mdash;are responsible for implementing national policing policies at the territorial level while maintaining close partnerships with local communities. Their responsibilities encompass patrol operations, criminal investigations, intelligence gathering, public safety, emergency management, crime prevention, and coordination with specialist police units during major incidents or security operations, thereby serving as the operational link between Police Headquarters and community-level policing.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise overall command and control of all policing operations within the assigned territorial division.</li>
          <li>Maintain public order, law enforcement, and public safety throughout the division.</li>
          <li>Supervise NPCs and NPPs.</li>
          <li>Direct crime prevention, patrol, emergency response, and criminal investigation activities.</li>
          <li>Coordinate responses to major incidents, disasters, and public security emergencies.</li>
          <li>Lead community policing initiatives and strengthen partnerships with residents, businesses, and community organizations.</li>
          <li>Oversee the deployment and management of personnel, operational resources, and policing assets.</li>
          <li>Monitor crime trends and implement intelligence-led policing strategies.</li>
          <li>Coordinate with specialist departments and Home Team agencies during joint operations.</li>
          <li>Ensure compliance with SPF operational policies, professional standards, and organizational directives.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="neighbourhoodPoliceCentreModal" tabindex="-1" aria-labelledby="neighbourhoodPoliceCentreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer3.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="neighbourhoodPoliceCentreModalLabel">Neighbourhood Police Centre (NPC)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> Second-tier territorial police command</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Superintendent of Police (SUPT) / Deputy Assistant Commissioner (DAC) Level</p>
        <p class="p-modal">The NPC is the second-tier territorial command within the SPF, operating under the supervision of a Land Division. Each NPC exercises operational control over several NPPs and patrol sectors within its assigned district, providing frontline policing, criminal investigations, emergency response, and community engagement. The NPC functions as the primary operational headquarters for coordinating local policing activities and implementing divisional policing strategies.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise command and control over all policing operations within the assigned district or NPC jurisdiction.</li>
          <li>Supervise NPPs, patrol officers, and response teams under the NPC.</li>
          <li>Coordinate emergency response, incident management, and frontline operational deployments.</li>
          <li>Direct investigations into criminal offenses occurring within the district and oversee case management.</li>
          <li>Implement crime prevention initiatives and community policing programs in collaboration with local stakeholders.</li>
          <li>Monitor local crime trends and develop targeted operational strategies to address emerging security concerns.</li>
          <li>Coordinate public order policing and security arrangements for community events and major gatherings.</li>
          <li>Allocate personnel, vehicles, and operational resources to ensure effective police coverage across the district.</li>
          <li>Liaise with specialist SPF departments and other Home Team agencies during major incidents and specialized investigations.</li>
          <li>Ensure compliance with SPF operational procedures, professional standards, and performance objectives.</li>
          <li>Maintain regular reporting to the Land Division Headquarters on operational activities, crime statistics, intelligence, and significant incidents.</li>
          <li>Promote public confidence by fostering strong relationships with residents, businesses, schools, and community organizations.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="neighbourhoodPolicePostModal" tabindex="-1" aria-labelledby="neighbourhoodPolicePostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer4.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="neighbourhoodPolicePostModalLabel">Neighbourhood Police Post (NPP)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> Lowest-level territorial police command</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Police Inspector (INSP) / Station Commander Level</p>
        <p class="p-modal">The NPP represents the third-tier territorial policing formation within the SPF. Operating under the command of an NPC, the NPP is the primary local police presence within residential communities. It functions as the first point of contact between the public and the police, delivering community-oriented policing, receiving reports, conducting Neighborhood patrols, gathering local intelligence, and fostering partnerships with residents, businesses, schools, and community organizations. Through its decentralized presence, the NPP enables the SPF to maintain close engagement with the public while supporting rapid response to local incidents.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise day-to-day command over policing activities within the assigned Neighborhood or patrol sector.</li>
          <li>Supervise frontline police officers and community policing personnel assigned to the NPP.</li>
          <li>Receive police reports, complaints, and requests for assistance from members of the public.</li>
          <li>Conduct routine foot, bicycle, vehicle, and community patrols to deter crime and maintain public order.</li>
          <li>Respond to local incidents and provide first-response policing until additional resources arrive.</li>
          <li>Conduct preliminary investigations into minor criminal offenses and gather evidence for referral to the NPC when necessary.</li>
          <li>Collect and disseminate local intelligence relating to crime trends, public safety concerns, and emerging security risks.</li>
          <li>Build strong partnerships with residents, grassroots organizations, schools, businesses, and local stakeholders through community policing initiatives.</li>
          <li>Organize crime prevention campaigns, Neighborhood watch programs, and public safety awareness activities.</li>
          <li>Monitor vulnerable locations and support the protection of public facilities and community assets.</li>
          <li>Coordinate with the NPC, Land Division Headquarters, and specialist police units during major incidents or special operations.</li>
          <li>Maintain operational readiness, accurate records, and timely reporting of incidents, arrests, and community engagement activities.</li>
          <li>Promote public confidence in the SPF through professional, responsive, and service-oriented policing.</li>
          <li>Support national policing initiatives by implementing SPF policies and operational directives at the local community level.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection

@push('service')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd-WVlGgZFJwAtPZkbAEca2Np6OI7CBTM&libraries=places,geometry,drawing"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('click', (e) => {
    const provinceSelectInput = e.target.closest('#provinceSelect .select-input');
    const provinceDropdown = document.querySelector('#provinceSelect .select-dropdown');
    const provinceSearch = document.getElementById('provinceSearch');

    if (provinceSelectInput) {
        if (provinceDropdown) provinceDropdown.classList.toggle('show');
    } else {
        const provinceSelect = document.getElementById('provinceSelect');
        if (provinceSelect && !provinceSelect.contains(e.target) && provinceDropdown) {
            provinceDropdown.classList.remove('show');
        }
    }
}, true);

document.addEventListener('keyup', (e) => {
    if (e.target.id === 'provinceSearchInput') {
        const keyword = e.target.value.toLowerCase();
        document.querySelectorAll('#provinceList li').forEach(li => {
            const text = li.textContent.toLowerCase();
            li.style.display = text.includes(keyword) ? '' : 'none';
        });
    }
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('province-checkbox')) {
        const selected = [...document.querySelectorAll('.province-checkbox:checked')]
            .map(cb => cb.parentElement.textContent.trim());
        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) {
            if (selected.length === 0) {
                provinceSearch.value = '';
                provinceSearch.placeholder = 'Select Province';
            } else if (selected.length <= 2) {
                provinceSearch.value = selected.join(', ');
            } else {
                provinceSearch.value = selected.length + ' Province Selected';
            }
        }
    }

});
</script>

<script>    // --- Map Initialization ---
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 1.3521, lng: 103.8198 },
        zoom: 11,
        mapTypeId: 'roadmap',
        mapTypeControl: true,
        fullscreenControl: true,
        streetViewControl: false
    });    // --- Global States ---
    let airportMarkers = [];
    let hospitalMarkers = [];
    let policeMarkers = [];
    let embassyMarkers = [];
    const infoWindow = new google.maps.InfoWindow();
    let drawnPolygonGeoJSON = null;
    let radiusCircle = null;
    let radiusPinMarker = null;
    let lastClickedLocation = null;
    let totalHospitals = 0;
    let totalAirports = 0;
    let totalPolice = 0;
    let totalEmbassies = 0;

    // --- Directions (in-map routing) ---
    const directionsService  = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers: false,
        polylineOptions: { strokeColor: '#1a73e8', strokeWeight: 5, strokeOpacity: 0.85 }
    });
    directionsRenderer.setMap(map);

    // "Clear Route" button
    const clearRouteBtn = document.createElement('div');
    clearRouteBtn.id = 'clearRouteBtn';
    clearRouteBtn.innerHTML = '&times; Clear Route';
    Object.assign(clearRouteBtn.style, {
        display: 'none',
        background: '#fff',
        border: '2px solid rgba(0,0,0,0.2)',
        borderRadius: '6px',
        padding: '6px 12px',
        fontSize: '13px',
        fontWeight: '600',
        cursor: 'pointer',
        margin: '10px',
        color: '#d32f2f',
        boxShadow: '0 2px 6px rgba(0,0,0,0.15)'
    });
    clearRouteBtn.title = 'Clear the current route';
    clearRouteBtn.addEventListener('click', () => {
        directionsRenderer.setDirections({ routes: [] });
        clearRouteBtn.style.display = 'none';
    });
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(clearRouteBtn);

    // --- Nearby Category Bar (Google Maps style) ---
    let categoryMarkers   = [];
    let activeCategoryBtn = null;

    const categoryBar = document.createElement('div');
    categoryBar.id = 'nearbyCategBar';
    Object.assign(categoryBar.style, {
        display:       'none',
        background:    'transparent',
        padding:       '8px 10px 0',
        display:       'none',
        gap:           '8px',
        flexWrap:      'nowrap',
        overflowX:     'auto',
        maxWidth:      '90vw',
        scrollbarWidth:'none'
    });

    const nearbyCategories = [
        { label: 'Hotels', icon: '\u{1F3E8}', type: 'lodging' }
    ];

    nearbyCategories.forEach(cat => {
        const btn = document.createElement('button');
        btn.textContent = cat.icon + ' ' + cat.label;
        Object.assign(btn.style, {
            display:      'inline-flex',
            alignItems:   'center',
            gap:          '4px',
            padding:      '6px 14px',
            borderRadius: '20px',
            border:       '1px solid rgba(0,0,0,0.12)',
            background:   '#fff',
            color:        '#222',
            fontSize:     '13px',
            fontWeight:   '500',
            cursor:       'pointer',
            whiteSpace:   'nowrap',
            boxShadow:    '0 1px 4px rgba(0,0,0,0.15)',
            transition:   'all 0.15s'
        });

        btn.addEventListener('click', () => {
            if (activeCategoryBtn === btn) {
                // toggle off
                clearCategoryMarkers();
                resetCategoryBtn(btn);
                activeCategoryBtn = null;
                return;
            }
            if (activeCategoryBtn) resetCategoryBtn(activeCategoryBtn);
            activeCategoryBtn = btn;
            btn.style.background = '#1a73e8';
            btn.style.color      = '#fff';
            btn.style.borderColor= '#1a73e8';
            showNearbyCategory(cat.type, cat.label);
        });

        categoryBar.appendChild(btn);
    });

    map.controls[google.maps.ControlPosition.TOP_CENTER].push(categoryBar);

    function resetCategoryBtn(btn) {
        btn.style.background  = '#fff';
        btn.style.color       = '#222';
        btn.style.borderColor = 'rgba(0,0,0,0.12)';
    }

    function clearCategoryMarkers() {
        categoryMarkers.forEach(m => m.setMap(null));
        categoryMarkers = [];
    }

    function showNearbyCategory(type, label) {
        if (!lastClickedLocation) return;
        clearCategoryMarkers();

        const center  = new google.maps.LatLng(lastClickedLocation.lat, lastClickedLocation.lng);
        const service = new google.maps.places.PlacesService(map);

        // Color map per category
        const iconColors = {
            lodging:    '#1a73e8',
            restaurant: '#e53935',
            pharmacy:   '#2e7d32',
            atm:        '#f57c00',
            parking:    '#1565c0',
            cafe:       '#6d4c41',
            hospital:   '#c62828',
        };
        const color = iconColors[type] || '#555';

        function makeSvgIcon(col) {
            const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='32' height='40' viewBox='0 0 32 40'>`
                      + `<path d='M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24S32 28 32 16C32 7.16 24.84 0 16 0z' fill='${col}'/>`
                      + `<circle cx='16' cy='16' r='7' fill='#fff'/>`
                      + `</svg>`;
            return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
        }

        const searchRadiusM  = 20000; // 20 km
        const searchRadiusKm = searchRadiusM / 1000;

        service.nearbySearch({ location: center, radius: searchRadiusM, type }, (results, status) => {
            if (status !== google.maps.places.PlacesServiceStatus.OK) {
                if (status === 'ZERO_RESULTS') {
                    alert(`No ${label.toLowerCase()} found within ${searchRadiusKm} km.`);
                } else {
                    alert(`Failed to load ${label.toLowerCase()}. Error status: ${status}. Please ensure "Places API" is enabled and billing is active.`);
                    console.error('PlacesService nearbySearch failed with status:', status);
                }
                return;
            }
            if (!results.length) return;

            results.forEach(place => {
                if (!place.geometry?.location) return;

                const marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map,
                    title: place.name,
                    icon: { url: makeSvgIcon(color), scaledSize: new google.maps.Size(32, 40) },
                    animation: google.maps.Animation.DROP
                });

                const dist     = google.maps.geometry.spherical.computeDistanceBetween(center, place.geometry.location);
                const distText = dist >= 1000 ? (dist / 1000).toFixed(1) + ' km' : Math.round(dist) + ' m';
                const rating   = place.rating ? `&#11088; ${place.rating.toFixed(1)}` : '';
                const destLat  = place.geometry.location.lat();
                const destLng  = place.geometry.location.lng();
                const safeName = (place.name || '').replace(/'/g, "\\'");

                marker.addListener('click', () => {
                    infoWindow.setContent(`
                        <div style="font-size:13px;min-width:190px;">
                            <h5 style="border-bottom:1px solid #ccc;margin:0 0 6px;font-size:14px;">${place.name}</h5>
                            <div style="color:#666;font-size:12px;margin-bottom:3px;">${label}</div>
                            ${rating  ? `<div style="font-size:12px;">${rating}</div>` : ''}
                            <div style="margin-top:4px;font-size:12px;color:#555;"> ${distText} from search location</div>
                            <div style="margin-top:8px;">
                                <button onclick="showRouteOnMap(${center.lat()},${center.lng()},${destLat},${destLng},'${safeName}')"
                                        style="display:inline-flex;align-items:center;gap:5px;
                                               background:#1a73e8;color:#fff;border:none;
                                               padding:5px 12px;border-radius:6px;font-size:12px;
                                               font-weight:500;cursor:pointer;">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                        <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                                    </svg>
                                    Get Directions
                                </button>
                            </div>
                        </div>`);
                    infoWindow.open(map, marker);
                });

                categoryMarkers.push(marker);
            });
        });
    }

    // Helper: close route panel
    function closeRoutePanel() {
        const panel = document.getElementById('routePanel');
        if (panel) panel.style.display = 'none';
        directionsRenderer.setDirections({ routes: [] });
        clearRouteBtn.style.display = 'none';
    }

    // Helper: draw route on map + show panel
    function showRouteOnMap(originLat, originLng, destLat, destLng, destName) {
        directionsService.route({
            origin: new google.maps.LatLng(originLat, originLng),
            destination: new google.maps.LatLng(destLat, destLng),
            travelMode: google.maps.TravelMode.DRIVING
        }, (result, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
                clearRouteBtn.style.display = 'inline-block';
                infoWindow.close();

                // --- Populate Route Panel ---
                const leg = result.routes[0].legs[0];
                const panel = document.getElementById('routePanel');
                document.getElementById('routePanelTitle').textContent = destName || 'Destination';
                document.getElementById('routeDistance').textContent  = leg.distance.text;
                document.getElementById('routeDuration').textContent  = leg.duration.text;

                const stepsEl = document.getElementById('routeSteps');
                stepsEl.innerHTML = leg.steps.map((step, i) => {
                    const raw = (step.html_instructions || step.instructions || '');
                    const instruction = raw.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
                    if (!instruction) return ''; // skip steps with no text
                    const icons = {
                        'Turn left':        '&larr;',
                        'Turn right':       '&rarr;',
                        'Keep left':        '&nwarr;',
                        'Keep right':       '&nearr;',
                        'Continue':         '&uarr;',
                        'Head':             '&uarr;',
                        'Roundabout':       '&#8635;',
                        'U-turn':           '&#10227;',
                        'Merge':            '&uarr;',
                        'Ramp':             '&nearr;',
                        'Destination':      '&#128205;',
                    };
                    let icon = '&bull;';
                    for (const [key, val] of Object.entries(icons)) {
                        if (instruction.startsWith(key)) { icon = val; break; }
                    }
                    const isLast = i === leg.steps.length - 1;
                    return `
                        <div style="display:flex;gap:10px;padding:8px 14px;
                                    border-bottom:${isLast ? 'none' : '1px solid #f0f0f0'};
                                    align-items:flex-start;">
                            <div style="min-width:22px;height:22px;background:${isLast ? '#395272' : '#e8f0fe'};
                                        border-radius:50%;display:flex;align-items:center;
                                        justify-content:center;font-size:12px;
                                        color:${isLast ? '#fff' : '#1a73e8'};flex-shrink:0;margin-top:1px;">
                                ${icon}
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:12px;color:#222;line-height:1.4;">${instruction}</div>
                                <div style="font-size:11px;color:#888;margin-top:2px;">${step.distance.text}</div>
                            </div>
                        </div>`;
                }).join('');

                panel.style.display = 'flex';
            } else {
                if (status === 'ZERO_RESULTS') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Route Not Found',
                        text: 'No driving route could be found between your location and the destination. The two locations may not be connected by road.',
                        confirmButtonColor: '#1a73e8',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Directions Error',
                        text: 'Could not get directions: ' + status,
                        confirmButtonColor: '#1a73e8',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    }

    // --- Polygon Draw (Custom Point-by-Point) ---
    let isDrawingPolygon = false;
    let polygonLatLngs = [];
    let activePolygon = null;
    let activePolyline = null;
    let cursorPolyline = null;
    let startMarker = null;

    const drawButton = document.createElement('div');
    drawButton.innerHTML = '&#11039;';
    drawButton.style.backgroundColor = 'white';
    drawButton.style.border = '2px solid rgba(0,0,0,0.2)';
    drawButton.style.borderRadius = '4px';
    drawButton.style.width = '34px';
    drawButton.style.height = '34px';
    drawButton.style.textAlign = 'center';
    drawButton.style.lineHeight = '30px';
    drawButton.style.fontSize = '18px';
    drawButton.style.cursor = 'pointer';
    drawButton.style.margin = '10px';
    drawButton.title = 'Draw Polygon (Click point by point, click starting point to finish)';

    map.controls[google.maps.ControlPosition.LEFT_TOP].push(drawButton);

    const clearButton = document.createElement('div');
    clearButton.innerHTML = '&#128465;';
    clearButton.style.backgroundColor = 'white';
    clearButton.style.border = '2px solid rgba(0,0,0,0.2)';
    clearButton.style.borderRadius = '4px';
    clearButton.style.width = '34px';
    clearButton.style.height = '34px';
    clearButton.style.textAlign = 'center';
    clearButton.style.lineHeight = '30px';
    clearButton.style.fontSize = '16px';
    clearButton.style.cursor = 'pointer';
    clearButton.style.margin = '10px 0';
    clearButton.title = 'Clear Polygon';

    map.controls[google.maps.ControlPosition.LEFT_TOP].push(clearButton);

    drawButton.addEventListener('click', () => {
        isDrawingPolygon = !isDrawingPolygon;
        if (isDrawingPolygon) {
            map.setOptions({ draggable: false });
            drawButton.style.backgroundColor = '#ccc';
            map.getDiv().style.cursor = 'crosshair';
            polygonLatLngs = [];
            if (activePolygon) activePolygon.setMap(null);
            if (activePolyline) activePolyline.setMap(null);
            if (cursorPolyline) cursorPolyline.setMap(null);
            if (startMarker) startMarker.setMap(null);
            activePolygon = null;
            activePolyline = new google.maps.Polyline({
                path: polygonLatLngs,
                strokeColor: '#0000FF',
                strokeOpacity: 0.8,
                strokeWeight: 3,
                clickable: false,
                map: map
            });
            cursorPolyline = new google.maps.Polyline({
                path: [],
                strokeColor: '#0000FF',
                strokeOpacity: 0.5,
                strokeWeight: 3,
                clickable: false,
                map: map
            });
            startMarker = null;
            drawnPolygonGeoJSON = null;
        } else {
            finishPolygon();
        }
    });

    map.addListener('click', (e) => {
        if (!isDrawingPolygon) return;
        polygonLatLngs.push(e.latLng);
        activePolyline.setPath(polygonLatLngs);

        if (polygonLatLngs.length === 1) {
            startMarker = new google.maps.Marker({
                position: e.latLng,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 6,
                    fillColor: '#FFFFFF',
                    fillOpacity: 1,
                    strokeColor: '#0000FF',
                    strokeWeight: 2,
                },
                zIndex: 999
            });
            startMarker.addListener('click', () => {
                if (isDrawingPolygon) finishPolygon();
            });
        }
    });

    map.addListener('mousemove', (e) => {
        if (!isDrawingPolygon || polygonLatLngs.length === 0) return;
        const lastPoint = polygonLatLngs[polygonLatLngs.length - 1];
        cursorPolyline.setPath([lastPoint, e.latLng]);
    });

    map.addListener('rightclick', () => {
        if (isDrawingPolygon) finishPolygon();
    });

    async function finishPolygon() {
        if (!isDrawingPolygon) return;
        isDrawingPolygon = false;
        map.setOptions({ draggable: true });
        drawButton.style.backgroundColor = 'white';
        map.getDiv().style.cursor = '';
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);

        if (polygonLatLngs.length > 2) {
            if (activePolyline) activePolyline.setMap(null);
            activePolygon = new google.maps.Polygon({
                paths: polygonLatLngs,
                strokeColor: '#0000FF',
                strokeOpacity: 0.8,
                strokeWeight: 3,
                fillColor: '#0000FF',
                fillOpacity: 0.2,
                editable: true,
                map: map
            });

            const coordinates = polygonLatLngs.map(p => [p.lng(), p.lat()]);
            coordinates.push([polygonLatLngs[0].lng(), polygonLatLngs[0].lat()]); // Close polygon

            drawnPolygonGeoJSON = {
                type: "Feature",
                geometry: { type: "Polygon", coordinates: [coordinates] },
                properties: {}
            };

            const updatePolygonFilter = async () => {
                if (!activePolygon) return;
                const path = activePolygon.getPath();
                if (path.getLength() > 2) {
                    const newCoords = [];
                    for (let i = 0; i < path.getLength(); i++) {
                        const xy = path.getAt(i);
                        newCoords.push([xy.lng(), xy.lat()]);
                    }
                    newCoords.push([path.getAt(0).lng(), path.getAt(0).lat()]);
                    drawnPolygonGeoJSON.geometry.coordinates = [newCoords];
                    await refreshCurrentFilters();
                }
            };

            google.maps.event.addListener(activePolygon.getPath(), 'set_at', updatePolygonFilter);
            google.maps.event.addListener(activePolygon.getPath(), 'insert_at', updatePolygonFilter);
            google.maps.event.addListener(activePolygon.getPath(), 'remove_at', updatePolygonFilter);

            await refreshCurrentFilters();
        } else {
            if (activePolyline) activePolyline.setMap(null);
            activePolyline = null;
            activePolygon = null;
            drawnPolygonGeoJSON = null;
        }
    }

    clearButton.addEventListener('click', async () => {
        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = null;
        cursorPolyline = null;
        startMarker = null;
        polygonLatLngs = [];
        drawnPolygonGeoJSON = null;
        isDrawingPolygon = false;
        map.setOptions({ draggable: true });
        drawButton.style.backgroundColor = 'white';
        map.getDiv().style.cursor = '';
        await refreshCurrentFilters();
    });    // --- Update Radius ---
    function updateRadiusCircleAndPin(radius = 0) {
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }

        if (radius > 0 && lastClickedLocation) {
            radiusCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.2,
                map: map,
                center: lastClickedLocation,
                radius: radius * 1000
            });
        }
    }

    // Red pin marker for searched location (separate from radius circle)
    function placeLocationPin(location, label) {
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        radiusPinMarker = new google.maps.Marker({
            position: location,
            map: map,
            title: label || 'Selected Location',
            icon: {
                url: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                scaledSize: new google.maps.Size(25, 41)
            },
            zIndex: 9999,
            animation: google.maps.Animation.DROP
        });
    }

    // Enable/disable radius section based on whether location is set
    function setRadiusSectionEnabled(enabled) {
        const section = document.getElementById('radiusSection');
        if (!section) return;
        section.style.opacity = enabled ? '1' : '0.4';
        section.style.pointerEvents = enabled ? 'auto' : 'none';
    }

    // --- Init Location Search â€” Google Places Autocomplete ---
    // .pac-container is repositioned to position:fixed via MutationObserver
    // to bypass Google Maps container overflow:hidden clipping.
    function initLocationSearch() {
        const input = document.getElementById('locationSearchMap');
        if (!input) {
            setTimeout(initLocationSearch, 300);
            return;
        }

        const clearBtn = document.getElementById('locationSearchClear');

        // â”€â”€ 1. Create Google Places Autocomplete â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode', 'establishment'],
            fields: ['geometry', 'name', 'formatted_address']
        });

        // â”€â”€ 2. Fix .pac-container position to avoid map overflow:hidden â”€â”€â”€â”€â”€â”€â”€
        // Google appends .pac-container to <body> but uses position:absolute,
        // calculated from the element's document offset. Because the map container
        // applies its own offset context, the top/left values are wrong.
        // We override with position:fixed + getBoundingClientRect().
        let pacContainer = null;

        function fixPacPosition() {
            if (!pacContainer) return;
            const rect = input.getBoundingClientRect();
            pacContainer.style.position   = 'fixed';
            pacContainer.style.zIndex     = '2147483647';
            pacContainer.style.top        = (rect.bottom + 2) + 'px';
            pacContainer.style.left       = rect.left + 'px';
            pacContainer.style.width      = rect.width + 'px';
            pacContainer.style.borderRadius = '0 0 8px 8px';
            pacContainer.style.boxShadow  = '0 8px 24px rgba(0,0,0,0.2)';
            pacContainer.style.fontFamily = 'inherit';
        }

        // Watch for Google to inject .pac-container into <body>
        const observer = new MutationObserver(() => {
            if (!pacContainer) {
                pacContainer = document.querySelector('.pac-container');
                if (pacContainer) {
                    fixPacPosition();
                    // Re-fix on every style mutation (Google repositions it on scroll etc.)
                    new MutationObserver(fixPacPosition).observe(
                        pacContainer, { attributes: true, attributeFilter: ['style'] }
                    );
                }
            }
        });
        observer.observe(document.body, { childList: true, subtree: false });

        // Keep in sync with input position on scroll / resize
        window.addEventListener('scroll', fixPacPosition, true);
        window.addEventListener('resize', fixPacPosition);
        input.addEventListener('focus',  fixPacPosition);
        input.addEventListener('input',  fixPacPosition);

        // â”€â”€ 3. Prevent map from capturing keyboard input â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        google.maps.event.addDomListener(input, 'keydown',   e => e.stopPropagation());
        google.maps.event.addDomListener(input, 'mousedown', e => e.stopPropagation());

        // â”€â”€ 4. Focus styling â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        input.addEventListener('focus', () => {
            input.style.borderColor = '#1a73e8';
            input.style.boxShadow   = '0 0 0 3px rgba(26,115,232,0.15)';
        });
        input.addEventListener('blur', () => {
            input.style.borderColor = '#ddd';
            input.style.boxShadow   = 'none';
        });

        // Show/hide Ã— button
        input.addEventListener('input', () => {
            if (clearBtn) clearBtn.style.display = input.value.length ? 'inline' : 'none';
        });

        // â”€â”€ 5. Handle place selection â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) return;

            const loc = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };
            lastClickedLocation = loc;

            map.panTo(loc);
            map.setZoom(10);

            const label = place.name || place.formatted_address || 'Location';
            placeLocationPin(loc, label);

            if (clearBtn) clearBtn.style.display = 'inline';

            const badge    = document.getElementById('locationFoundBadge');
            const badgeName = document.getElementById('locationFoundName');
            if (badge)     badge.style.display = 'block';
            if (badgeName) badgeName.textContent = label;

            setRadiusSectionEnabled(true);
            const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);
            updateRadiusCircleAndPin(radius);
            refreshCurrentFilters();

            // Show category bar
            categoryBar.style.display = 'flex';
        });

        // â”€â”€ 6. Clear button â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                input.value = '';
                clearBtn.style.display = 'none';
                if (pacContainer) pacContainer.style.display = 'none';

                const badge = document.getElementById('locationFoundBadge');
                if (badge) badge.style.display = 'none';

                if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
                if (radiusCircle)    { radiusCircle.setMap(null);    radiusCircle    = null; }
                lastClickedLocation = null;

                // Hide category bar & clear category markers
                categoryBar.style.display = 'none';
                clearCategoryMarkers();
                if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

                setRadiusSectionEnabled(false);
                const rEl    = document.getElementById('radiusRangeMap');
                const rValEl = document.getElementById('radiusValueMap');
                if (rEl)    rEl.value          = 0;
                if (rValEl) rValEl.textContent = '0';

                refreshCurrentFilters();
                input.focus();
            });
        }
    }

    // --- Fetch Data ---
    async function fetchData(url, filters = {}) {
        const params = new URLSearchParams();
        Object.entries(filters).forEach(([k, v]) => {
            if (Array.isArray(v)) v.forEach(x => params.append(`${k}[]`, x));
            else if (v !== '' && v != null) params.append(k, v);
        });
        if (drawnPolygonGeoJSON) params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));
        //  console.log(url + '?' + params.toString());

        try {
            const res = await fetch(`${url}?${params.toString()}`);
            return res.ok ? await res.json() : [];
        } catch (e) {
            console.error(`Error fetching ${url}:`, e);
            return [];
        }
    }    // --- Add Markers ---
    function clearMarkers(markersArray) {
        if (!markersArray) return;
        markersArray.forEach(m => m.setMap(null));
        markersArray.length = 0;
    }

    function addMarkers(data, markersArray, defaultIconUrl) {
        clearMarkers(markersArray);
        data.forEach(item => {
            if (!item || !item.latitude || !item.longitude) return;

            let iconSize = new google.maps.Size(24, 24);

            // Police icon lebih kecil
            if (item.name_police) {
                iconSize = new google.maps.Size(12, 12);
            }

            const iconUrl = item.icon || defaultIconUrl || 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png';

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(item.latitude), lng: parseFloat(item.longitude) },
                map: map,
                icon: {
                    url: iconUrl,
                    scaledSize: iconSize
                }
            });

            let itemName = '', detailUrl = '', popupContent = '';

            if (item.airport_name) {
                itemName = item.airport_name;
                detailUrl = `/airports/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;"><a href="${detailUrl}" style="color:inherit;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='inherit'">${itemName}</a></h5>
                    <strong>Classification:</strong> ${item.category || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.city_name ? ', ' + item.city_name : ''}
                        ${item.province_name ? ', ' + item.province_name : ''}, Singapore <br>
                    <strong>Website:</strong> ${item.website || 'N/A'} <br>
                `;
            } else if (item.name) {
                itemName = item.name;
                detailUrl = `/hospitals/${item.id}`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;"><a href="${detailUrl}" style="color:inherit;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='inherit'">${itemName}</a></h5>
                    <strong>Global Classification:</strong> ${item.facility_category || 'N/A'}<br>
                    <strong>Country Classification:</strong> ${item.facility_level || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.city ? ', ' + item.city : ''}
                        ${item.provinces_region ? ', ' + item.provinces_region : ''}, Singapore <br>
                `;
            } else if (item.name_police) {
                itemName = item.name_police;
                detailUrl = `/police/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;"><a href="${detailUrl}" style="color:inherit;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='inherit'">${itemName}</a></h5>
                    <strong>Category:</strong> ${item.category || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.city ? ', ' + item.city : ''}
                        ${item.provinces_region ? ', ' + item.provinces_region : ''}, Singapore <br>
                    <strong>Phone:</strong> ${item.telephone || 'N/A'}<br>
                    <strong>Fax:</strong> ${item.fax || 'N/A'}<br>
                    <strong>Email:</strong> ${item.email || 'N/A'}<br>
                    <strong>Website:</strong> ${item.website || 'N/A'}<br>
                `;
            }
            else if (item.name_embassiees) {
                itemName = item.name_embassiees;
                detailUrl = `/embassiees/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;"><a href="${detailUrl}" style="color:inherit;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='inherit'">${itemName}</a></h5>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.city ? ', ' + item.city : ''}
                        ${item.provinces_region ? ', ' + item.provinces_region : ''}, Singapore <br>
                    <strong>Phone:</strong> ${item.telephone || 'N/A'}<br>
                    <strong>Fax:</strong> ${item.fax || 'N/A'}<br>
                    <strong>Email:</strong> ${item.email || 'N/A'}<br>
                    <strong>Website:</strong> ${item.website || 'N/A'}<br>
                `;
            }



            marker.addListener('click', () => {
                const destLat = parseFloat(item.latitude);
                const destLng = parseFloat(item.longitude);

                let directionsBtn = '';
                if (lastClickedLocation && !isNaN(destLat) && !isNaN(destLng)) {
                    const oLat = lastClickedLocation.lat;
                    const oLng = lastClickedLocation.lng;
                    directionsBtn = `
                        <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;display:flex;gap:6px;flex-wrap:wrap;">
                            <button onclick="showRouteOnMap(${oLat},${oLng},${destLat},${destLng},'${(itemName||'').replace(/'/g,"\\'")}')"
                               style="display:inline-flex;align-items:center;gap:5px;
                                      background:#1a73e8;color:#fff;border:none;
                                      padding:5px 12px;border-radius:6px;font-size:12px;
                                      font-weight:500;cursor:pointer;">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                                </svg>
                                Get Directions
                            </button>
                            <a href="${detailUrl}"
                               style="display:inline-flex;align-items:center;gap:5px;
                                      background:#395272;color:#fff;text-decoration:none;
                                      padding:5px 12px;border-radius:6px;font-size:12px;
                                      font-weight:500;"
                               onmouseover="this.style.background='#5686c3'"
                               onmouseout="this.style.background='#395272'">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/>
                                </svg>
                                Read More
                            </a>
                        </div>`;
                } else if (detailUrl) {
                    directionsBtn = `
                        <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;">
                            <a href="${detailUrl}"
                               style="display:inline-flex;align-items:center;gap:5px;
                                      background:#395272;color:#fff;text-decoration:none;
                                      padding:5px 12px;border-radius:6px;font-size:12px;
                                      font-weight:500;"
                               onmouseover="this.style.background='#5686c3'"
                               onmouseout="this.style.background='#395272'">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/>
                                </svg>
                                Read More
                            </a>
                        </div>`;
                }

                infoWindow.setContent(`<div style="font-size:13px; min-width: 200px;">${popupContent}${directionsBtn}</div>`);
                infoWindow.open(map, marker);
            });

            markersArray.push(marker);
        });
    }

    // --- Apply Filters ---
    async function applyFiltersWithMapControl(
        facilities = [],
        hospitalLevels = [],
        airportClasses = [],
        provinces = [],
        radius = 0,
        airportName = '',
        hospitalName = ''
    ) {
        let common = { provinces };
        if (radius > 0 && lastClickedLocation) {
            common.radius = radius;
            common.center_lat = lastClickedLocation.lat;
            common.center_lng = lastClickedLocation.lng;
        }

        totalHospitals = 0;
        totalAirports = 0;
        totalPolice = 0;
        totalEmbassies = 0;

        // hanya facility yang dicentang yang ditampilkan
        // (checkbox "All" mencentang semuanya sekaligus)
        const showHospital = facilities.includes('hospital');
        const showAirport = facilities.includes('airport');
        const showPolice = facilities.includes('police');
        const showEmbassy = facilities.includes('embassy');

         // === HOSPITALS ===
        if (showHospital) {
             const result = await fetchData('/api/hospital', {
                ...common,
                name: hospitalName,
                category: hospitalLevels
            });

            addMarkers(result.hospitals, hospitalMarkers, null);

            totalHospitals = result.hospitals.length;
        } else {
            clearMarkers(hospitalMarkers);
        }

        // === AIRPORTS ===
       if (showAirport) {

            const airportResponse = await fetchData('/api/airports', {
                ...common,
                name: airportName
            });

            const airports = Array.isArray(airportResponse)
                    ? airportResponse
                    : airportResponse.airports || [];
            const categoryCounts = airportResponse.categoryCounts || {};

            const filteredAirports = airports.filter(a => {

                if (airportClasses.length === 0) {
                    return true;
                }

                if (!a.category) {
                    return false;
                }

                const dbCategories = a.category
                    .split(',')
                    .map(c => c.trim().toLowerCase());

                return airportClasses.some(sel =>
                    dbCategories.includes(sel.toLowerCase())
                );
            });

            addMarkers(
                filteredAirports,
                airportMarkers,
                'https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png'
            );

            totalAirports = filteredAirports.length;
        }else {
            clearMarkers(airportMarkers);
        }

        // === POLICE ===
       if (showPolice) {

            const result = await fetchData('/api/polices', {
                ...common
            });

            const police = result.polices || [];
            const categoryCounts = result.categoryCounts || {};

            addMarkers(
                police,
                policeMarkers,
                null
            );

            totalPolice = police.length;

            Object.keys(categoryCounts).forEach(cat => {

                const id = cat.replace(/[^a-zA-Z0-9]/g, '-');

                const el = document.getElementById(`count-${id}`);

                if (el) {
                    el.textContent = categoryCounts[cat];
                }
            });
        } else {
            clearMarkers(policeMarkers);
        }

        // === EMBASSY ===
        if (showEmbassy) {

            const embassies = await fetchData('/api/embassy', {
                ...common
            });

            addMarkers(
                embassies,
                embassyMarkers,
                '/images/embassy-icon-new.png'
            );

            totalEmbassies = embassies.length;

        } else {
            clearMarkers(embassyMarkers);
        }

        updateRadiusCircleAndPin(radius);
        updateTotalCountDisplay();
    }

    function updateTotalCountDisplay() {
        // Panel filter di-attach oleh Google Maps secara async,
        // jadi elemen counter bisa belum ada saat load pertama.
        const setCount = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.textContent = value;
        };

        setCount('airportCount', totalAirports);
        setCount('hospitalCount', totalHospitals);
        setCount('policeCount', totalPolice);
        setCount('embassyCount', totalEmbassies);
    }    // === COMBINED PANEL ===
    const combinedPanelDiv = document.createElement('div');
    combinedPanelDiv.id = 'combinedPanelDiv';
    Object.assign(combinedPanelDiv.style, {
        background: 'white',
        borderRadius: '8px',
        boxShadow: '0 2px 6px rgba(0,0,0,0.2)',
        minWidth: '260px',
        maxWidth: '290px',
        overflow: 'visible',
        margin: '10px'
    });

    combinedPanelDiv.innerHTML = `
        <button style="background:#007bff;color:white;border:none;width:100%;padding:8px;border-radius:8px 8px 0 0;font-weight:600;letter-spacing:0.3px;">Filter &amp; Radius</button>

        <!-- Search Location - NOT inside scrollable div so dropdown is never clipped -->
        <div id="searchSection" style="padding:10px 10px 6px 10px;background:white;position:relative;">
            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;"> Search Location</strong>
            <div style="position:relative;margin-top:5px;">
                <input
                    type="text"
                    id="locationSearchMap"
                    placeholder="Search Location..."
                    autocomplete="off"
                    style="width:100%;padding:7px 30px 7px 9px;border:1.5px solid #ddd;border-radius:6px;font-size:13px;box-sizing:border-box;"
                >
                <span id="locationSearchClear" title="Clear"
                    style="position:absolute;right:8px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:15px;color:#aaa;display:none;">&times;</span>
                <!-- Autocomplete dropdown - inside input wrapper so position relative works correctly -->
                <div id="locationAutocompleteList"
                    style="display:none;position:absolute;left:0;right:0;top:100%;margin-top:2px;background:white;border:1px solid #ddd;border-radius:6px;box-shadow:0 4px 16px rgba(0,0,0,0.18);z-index:999999;max-height:220px;overflow-y:auto;"
                ></div>
            </div>
            <div id="locationFoundBadge" style="display:none;margin-top:6px;background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:4px 8px;font-size:12px;color:#2e7d32;">
                &#128204; <span id="locationFoundName"></span>
            </div>
        </div>

        <!-- Radius - also outside scrollable, enabled after location selected -->
        <div id="radiusSection" style="padding:0 10px 0 10px;opacity:0.4;pointer-events:none;transition:opacity 0.3s;">
            <hr style="margin:8px 0;">
            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">&#11096; Radius: <span id="radiusValueMap">0</span> km</strong>
            <input type="range" id="radiusRangeMap" min="0" max="500" value="0" style="width:100%;margin:4px 0;">
            <div style="display:flex;justify-content:space-between;font-size:11px;color:#888;margin-bottom:5px;">
                <span>0</span><span>250 km</span><span>500 km</span>
            </div>
            <div style="display:flex;gap:5px;margin-bottom:6px;">
                <button id="applyRadiusMap" class="btn btn-sm btn-primary flex-fill">Apply</button>
                <button id="resetRadiusMap" class="btn btn-sm btn-danger flex-fill">Reset</button>
            </div>
        </div>

        <!-- Scrollable filters below -->
        <div id="filterPanel" style="padding:0 10px 10px 10px;max-height:52vh;overflow-y:auto;border-top:1px solid #eee;">
            <div style="padding-top:8px;">
            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Facilities</strong>

                    <div class="facility-list">

                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="airport" id="facilityAirport" checked>
                            <label class="form-check-label" for="facilityAirport">
                                <span class="facility-name">Aviation</span>
                                <span class="facility-count" id="airportCount">0</span>
                            </label>
                        </div>

                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="hospital" id="facilityHospital">
                            <label class="form-check-label" for="facilityHospital">
                                <span class="facility-name">Medical</span>
                                <span class="facility-count" id="hospitalCount">0</span>
                            </label>
                        </div>

                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="police" id="facilityPolice">
                            <label class="form-check-label" for="facilityPolice">
                                <span class="facility-name">Police</span>
                                <span class="facility-count" id="policeCount">0</span>
                            </label>
                        </div>

                        <div class="facility-item">
                            <input class="form-check-input facility-checkbox" type="checkbox" value="embassy" id="facilityEmbassy">
                            <label class="form-check-label" for="facilityEmbassy">
                                <span class="facility-name">Embassies</span>
                                <span class="facility-count" id="embassyCount">0</span>
                            </label>
                        </div>

                        <div class="facility-item">
                            <input class="form-check-input" type="checkbox" value="all" id="facilityAll">
                            <label class="form-check-label" for="facilityAll">
                                <span class="facility-name is-all">All / Clear All</span>
                            </label>
                        </div>

                    </div>

                    <hr>
                    <div class="filter-box" id="provinceSelect">
                        <label class="filter-label">
                            Province
                        </label>

                        <div class="select-input">
                            <input
                                type="text"
                                id="provinceSearch"
                                placeholder="Select Province"
                                readonly
                            >
                            <i class="bi bi-chevron-down"></i>
                        </div>

                        <div class="select-dropdown">
                            <input
                                type="text"
                                class="dropdown-search"
                                id="provinceSearchInput"
                                placeholder="Search Province..."
                            >

                            <ul id="provinceList">
                                @foreach($provinces as $province)
                                <li>
                                    <label>
                                        <input
                                            type="checkbox"
                                            class="province-checkbox"
                                            value="{{ $province->id }}"
                                        >
                                        {{ $province->provinces_region }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <hr>
                    <button id="resetMapFilter"
                            class="btn btn-sm btn-secondary w-100"
                            style="margin-top:auto;">
                        Reset All
                    </button>
                    <div id="totalCountDisplay" style="margin-top:8px;text-align:center;font-size:13px;"></div>
                </div>
            </div>`;            google.maps.event.addDomListener(combinedPanelDiv, 'click', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'dblclick', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'mousedown', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'touchstart', e => e.stopPropagation());
            google.maps.event.addDomListener(combinedPanelDiv, 'wheel', e => e.stopPropagation());
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(combinedPanelDiv);

    // === FACILITIES "ALL" CHECKBOX SYNC ===
    // Didaftarkan pada fase capture SEBELUM listener filter di bawah,
    // supaya state checkbox sudah tersinkron saat filter dibaca.
    function syncFacilityAllCheckbox() {
        const all = document.getElementById('facilityAll');
        if (!all) return;
        const boxes = [...document.querySelectorAll('.facility-checkbox')];
        all.checked = boxes.length > 0 && boxes.every(cb => cb.checked);
    }

    document.addEventListener('change', e => {
        if (!e.target) return;

        if (e.target.id === 'facilityAll') {
            document.querySelectorAll('.facility-checkbox').forEach(cb => {
                cb.checked = e.target.checked;
            });
            return;
        }

        if (e.target.classList && e.target.classList.contains('facility-checkbox')) {
            syncFacilityAllCheckbox();
        }
    }, true);

    // === INIT SELECT2 ===
    setTimeout(() => {
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select-search-airport').select2({ placeholder: 'Select Airport', width: '100%' });
            $('.select-search-hospital').select2({ placeholder: 'Select Hospital', width: '100%' });
        }
    }, 300);

    function getCurrentFiltersFromUI() {
        const facilities = [...document.querySelectorAll('.facility-checkbox:checked')].map(el => el.value);
        const hLevels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
        const aClasses = [...document.querySelectorAll('input[name="airportClass"]:checked')].map(e => e.value);
        const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
        const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);
        // untuk select2, .value akan tetap bekerja because Select2 keeps value in the <select>
        const airportName = document.getElementById('airport_name_map')?.value || '';
        const hospitalName = document.getElementById('hospital_name_map')?.value || '';
        return { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName };
    }

    async function refreshCurrentFilters() {
        const {
            facilities,
            hLevels,
            aClasses,
            provs,
            radius,
            airportName,
            hospitalName
        } = getCurrentFiltersFromUI();

        await applyFiltersWithMapControl(
            facilities,
            hLevels,
            aClasses,
            provs,
            radius,
            airportName,
            hospitalName
        );
    }

    // === Event Logic ===
    document.addEventListener('change', async e => {
        const facilities = [...document.querySelectorAll('.facility-checkbox:checked')].map(el => el.value);
        const hLevels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
        const aClasses = [...document.querySelectorAll('input[name="airportClass"]:checked')].map(e => e.value);
        const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
        const radius = parseInt(document.getElementById('radiusRangeMap').value || 0);
        const airportName = document.getElementById('airport_name_map')?.value || '';
        const hospitalName = document.getElementById('hospital_name_map')?.value || '';

        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
    }, true);

    // === INPUT: update tampilan radius saat slider digeser (live) ===
document.addEventListener('input', (e) => {
    if (e.target && e.target.id === 'radiusRangeMap') {
        const r = parseInt(e.target.value || 0);
        const el = document.getElementById('radiusValueMap');
        if (el) el.textContent = r;
        // hanya update tampilan lingkaran saja (belum apply ke filter)
        updateRadiusCircleAndPin(r);
    }
}, true);

// === CLICK: apply / reset radius dan reset all ===
// Menggunakan event capturing (true) agar tidak diblok oleh stopPropagation pada map control
document.addEventListener('click', async (e) => {
    if (!e.target) return;

    // APPLY RADIUS => ambil filter sekarang lalu panggil applyFiltersWithMapControl dengan radius
    if (e.target.id === 'applyRadiusMap') {
        const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
        if (radius > 0 && !lastClickedLocation) {
            alert('Cari lokasi terlebih dahulu menggunakan kolom "Search Location" sebelum menggunakan filter radius.');
            return;
        }
        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        return;
    }

    // RESET RADIUS (hanya reset radius visual & reapply tanpa radius)
    if (e.target.id === 'resetRadiusMap') {
        const rEl = document.getElementById('radiusRangeMap');
        const rValEl = document.getElementById('radiusValueMap');
        if (rEl) rEl.value = 0;
        if (rValEl) rValEl.textContent = '0';

        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const { facilities, hLevels, aClasses, provs, airportName, hospitalName } = getCurrentFiltersFromUI();
        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, 0, airportName, hospitalName);
        return;
    }

    // RESET ALL FILTERS (tombol Reset All)
    if (e.target.id === 'resetMapFilter') {
        // 1) UI reset (default: hanya Aviation yang aktif)
        document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(cb => { cb.checked = false; });
        const defaultFacility = document.getElementById('facilityAirport');
        if (defaultFacility) defaultFacility.checked = true;
        syncFacilityAllCheckbox();
        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) provinceSearch.value = '';
        const provinceSearchInput = document.getElementById('provinceSearchInput');
        if (provinceSearchInput) provinceSearchInput.value = '';
        document.querySelectorAll('#provinceList li').forEach(li => { li.style.display = ''; });

        // sembunyikan sub-panels
        const af = document.getElementById('airportFilter');
        const hf = document.getElementById('hospitalFilter');
        if (af) af.style.display = 'none';
        if (hf) hf.style.display = 'none';

        // 2) Reset Select2 (jika ada)
        if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
            $('.select-search-airport').each(function () { $(this).val(null).trigger('change'); });
            $('.select-search-hospital').each(function () { $(this).val(null).trigger('change'); });
        } else {
            const airportSel = document.getElementById('airport_name_map');
            const hospitalSel = document.getElementById('hospital_name_map');
            if (airportSel) airportSel.value = '';
            if (hospitalSel) hospitalSel.value = '';
        }

        // 3) Reset radius visual & location search
        const radiusRange = document.getElementById('radiusRangeMap');
        const radiusValue = document.getElementById('radiusValueMap');
        if (radiusRange) radiusRange.value = 0;
        if (radiusValue) radiusValue.textContent = '0';
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const locInput = document.getElementById('locationSearchMap');
        const locClear = document.getElementById('locationSearchClear');
        const locBadge = document.getElementById('locationFoundBadge');
        if (locInput) locInput.value = '';
        if (locClear) locClear.style.display = 'none';
        if (locBadge) locBadge.style.display = 'none';

        const fixedDrop = document.getElementById('locationDropdownFixed');
        if (fixedDrop) fixedDrop.style.display = 'none';
        setRadiusSectionEnabled(false);

        // 4) Remove drawn polygon and layers
        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = null;
        cursorPolyline = null;
        startMarker = null;
        polygonLatLngs = [];
        drawnPolygonGeoJSON = null;

        // 5) Clear markers and counters
        if (airportMarkers) clearMarkers(airportMarkers);
        if (hospitalMarkers) clearMarkers(hospitalMarkers);
        if (policeMarkers) clearMarkers(policeMarkers);
        if (embassyMarkers) clearMarkers(embassyMarkers);
        totalAirports = 0;
        totalHospitals = 0;
        totalPolice = 0;
        totalEmbassies = 0;
        updateTotalCountDisplay();

        // 6) Re-fetch data sesuai default (Aviation)
        await applyFiltersWithMapControl(['airport'], [], [], [], 0, '', '');

        e.stopPropagation();
        e.preventDefault();
        return;
    }
}, true);

// === LISTEN TO CHANGE on filter inputs (kategori/provinsi/select nama) ===
// Ini memastikan ketika user change checkbox / select2, filter langsung ter-apply
function bindFilterChangeAutoApply() {
    // checkbox change
    document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(el => {
        el.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    });

    // select2 change (nama)
    // if Select2 is used, listen with jQuery; otherwise plain change event above covers plain <select>
    if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
        $(document).on('change', '#airport_name_map, #hospital_name_map', async function () {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    } else {
        document.getElementById('airport_name_map')?.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
        document.getElementById('hospital_name_map')?.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    }
}

// call binding after panel is rendered
setTimeout(() => {
    bindFilterChangeAutoApply();
    initLocationSearch();
}, 350);

    // --- Initial Load ---
    // Tunggu sampai panel filter benar-benar ter-attach ke DOM oleh Google Maps,
    // supaya default checkbox (Aviation) terbaca oleh getCurrentFiltersFromUI().
    (function initialLoad() {
        if (!document.getElementById('facilityAirport')) {
            setTimeout(initialLoad, 100);
            return;
        }
        refreshCurrentFilters();
    })();
</script>

@endpush
