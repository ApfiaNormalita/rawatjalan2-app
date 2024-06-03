@extends('layouts/main')
@section('title','Detail pasien ')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Menggunakan Bootstrap dari CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <title>Dashboard Obat</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript">


    function get_rawatjalan() {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'http://192.168.78.114/silk2024-slim-main/public/rawatjalan');
            xhr.send();

            xhr.onload = function() {
                if (xhr.status != 200 && xhr.status != 201) {
                    alert(`Error ${xhr.status}: ${xhr.statusText}`);
                } else {
                    let table = document.getElementById("outputTable").getElementsByTagName('tbody')[0];
                    table.innerHTML = ''; // Mengosongkan tabel sebelum menambahkan data baru

                    let data = JSON.parse(xhr.responseText);
                    data.forEach(function(item) {
                        var row = document.createElement("tr");
                        // id table tindakan
                        var id = document.createElement("td");
                        id.textContent = item.id;
                        //row.appendChild(id);

                        var id_rm = document.createElement("td");
                        id_rm.textContent = item.id_rm;
                        row.appendChild(id_rm);

                        var no_rm = document.createElement("td");
                        no_rm.textContent = item.no_rm;
                        row.appendChild(no_rm);

                                               
                        var actions = document.createElement("td");
                            var buttonNamaRM = document.createElement("button");
                            buttonNamaRM.textContent = item.nama;
                            buttonNamaRM.className = 'btn btn-primary btn-sm px-2 mt-2 ';
                            buttonNamaRM.style.backgroundColor = '#87CEFA'; // Warna latar belakang kustom
                            buttonNamaRM.style.color = '#000000'; // Warna teks kustom
                            buttonNamaRM.onclick = function() {
                                editDataRM(item.id_rm);
                            };
                            actions.appendChild(buttonNamaRM);                        
                        row.appendChild(actions);                       

                        var deskripsi = document.createElement("td");
                        deskripsi.textContent = item.deskripsi;
                        row.appendChild(deskripsi);

                        var id_obat = document.createElement("td");
                        id_obat.textContent = item.id_obat;
                        //row.appendChild(id_obat);

                        var sku = document.createElement("td");
                        sku.textContent = item.sku;
                        row.appendChild(sku);

                        var nama_obat = document.createElement("td");
                        nama_obat.textContent = item.nama_obat;
                        row.appendChild(nama_obat);

                        var jumlah = document.createElement("td");
                        jumlah.textContent = item.jumlah;
                        row.appendChild(jumlah);
                        
                        var label_catatan = document.createElement("td");
                        label_catatan.textContent = item.label_catatan;
                        row.appendChild(label_catatan);

                        var actions = document.createElement("td");
                            var updateButtonTindakan = document.createElement("button");
                            updateButtonTindakan.textContent = '📝Tindakan';
                            updateButtonTindakan.className = 'btn custom-button btn-sm px-2 mt-2 ';
                            updateButtonTindakan.style.backgroundColor = '#FFB6C1'; // Warna latar belakang kustom
                            updateButtonTindakan.style.color = '#000000'; // Warna teks kustom
                            updateButtonTindakan.onclick = function() {
                                editDataTindakan(item.id, item.id_rm);
                            };
                            actions.appendChild(updateButtonTindakan);                        

                            var updateButton = document.createElement("button");
                            updateButton.textContent = '📝Obat  ';
                            updateButton.className = 'btn custom-button px-2 mt-2 btn-sm' ;
                            updateButton.style.backgroundColor = '#32CD32'; // Warna latar belakang kustom
                            updateButton.style.color = '#F0F8FF'; // Warna teks kustom
                            updateButton.onclick = function() {
                                editDataObat(item.id, item.id_rm, item.sku);
                            };
                            actions.appendChild(updateButton);

                            var tambahObatButton = document.createElement("button");
                            tambahObatButton.textContent = '➕Obat  ';
                            tambahObatButton.className = 'btn custom-button px-2 mt-2 btn-sm' ;
                            tambahObatButton.style.backgroundColor = '#90EE90'; // Warna latar belakang kustom
                            tambahObatButton.style.color = '#000000'; // Warna teks kustom
                            tambahObatButton.onclick = function() {
                                tambahObat(item.id, item.id_rm);
                            };
                            actions.appendChild(tambahObatButton);

                        row.appendChild(actions);

                        table.appendChild(row);
                    });
                }
            };

            xhr.onerror = function() {
                alert("Request failed");
            };
    }    

    function tambahObat(id, id_rm) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', `http://192.168.78.114/silk2024-slim-main/public/rawatjalan/tambah/obat/${id}/${id_rm}`);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status != 200 && xhr.status != 201) {
                alert(`Error ${xhr.status}: ${xhr.statusText}`);
            } else {
                let response = JSON.parse(xhr.responseText);
                if (response.status === 'berhasil') {
                    alert('Berhasil Tambah Obat ✅, Selanjutnya Silahkan edit');
                    get_rawatjalan();
                } else {
                    alert('Gagal Tambah Obat⛔');
                }
            }
        };

        xhr.onerror = function() {
            alert('Request failed');
        };

        xhr.send();
     }

//----------------------REKAM MEDIS-------------------------------------------
    function editDataRM(id_rm) {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `http://192.168.78.114/silk2024-slim-main/public/rawatjalan/rekammedis/${id_rm}`);
        xhr.send();

        xhr.onload = function() {
            if (xhr.status != 200) {
                alert(`Error ${xhr.status}: ${xhr.statusText}`);
            } else {
                let data = JSON.parse(xhr.responseText);
                    document.getElementById('updateId_RM').value = data.id_rm;
                    document.getElementById('updateNoRm').value = data.no_rm;
                    document.getElementById('updateKeluhan').value = data.keluhan;
                    document.getElementById('updateTinggi').value = data.tinggi;
                    document.getElementById('updateBerat').value = data.berat;
                    document.getElementById('updateTensi').value = data.tensi;
                    document.getElementById('updateDokter').value = data.dokter;
                    document.getElementById('updateStatus_obat').value = data.status_obat;
                    document.getElementById('updateTanggal').value = data.tanggal;
                    jQuery('#updateModalRM').modal('show'); // Menampilkan modal   
            } 
        };

        xhr.onerror = function() {
            alert('Request failed');
        };
    }

//----------------------TINDAKAN-------------------------------------------
    function editDataTindakan(id, id_rm) {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `http://192.168.78.114/silk2024-slim-main/public/rawatjalan/Tindakan/${id}/${id_rm}`);
        xhr.send();

        xhr.onload = function() {
            if (xhr.status != 200) {
                alert(`Error ${xhr.status}: ${xhr.statusText}`);
            } else {
                let data = JSON.parse(xhr.responseText);
                    document.getElementById('updateId').value = data.id;
                    document.getElementById('updateIDRM').value = data.id_rm;
                    document.getElementById('updateNo_Rm').value = data.no_rm;
                    document.getElementById('updateTindakan').value = data.deskripsi;
                    jQuery('#updateModalTindakan').modal('show'); // Menampilkan modal   
            } 
        };

        xhr.onerror = function() {
            alert('Request failed');
        };
    }
    function submitUpdateFormTindakan(id, id_rm) {
        let data = {
            id: id,             // Menambahkan id ke dalam objek data
            id_rm: id_rm,       // Menambahkan id_rm ke dalam objek data
            deskripsi: document.getElementById('updateTindakan').value
        };

        let xhr = new XMLHttpRequest();
        xhr.open('PUT', `http://192.168.78.114/silk2024-slim-main/public/rawatjalan/Tindakan/${id}/${id_rm}`);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status != 200) {
                alert(`Error ${xhr.status}: ${xhr.statusText}`);
            } else {
                alert('Data berhasil diupdate ✅');
                $('#updateModalTindakan').modal('hide'); // Menyembunyikan modal setelah update
                get_rawatjalan(); // Memuat ulang data setelah update
            }
        };

        xhr.onerror = function() {
            alert('Request failed');
        };

        xhr.send(JSON.stringify(data));
    }

// -----------------OBAT -----------------------
    function editDataObat(id, id_rm,sku) {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `http://192.168.78.114/silk2024-slim-main/public/rawatjalan/obat/${id}/${id_rm}/${sku}`);
        xhr.send();

        xhr.onload = function() {
            if (xhr.status != 200) {
                alert(`Error ${xhr.status}: ${xhr.statusText}`);
            } else {
                let data = JSON.parse(xhr.responseText);
                updateid
                document.getElementById('updateid').value = data.id;
                    document.getElementById('updateid_rm').value = data.id_rm;
                    document.getElementById('updateNamaObat').value = data.nama_obat;                    
                    document.getElementById('updateNoRm').value = data.no_rm;
                    document.getElementById('updatesku').value = data.sku;
                    document.getElementById('updatelabelcatatan').value = data.label_catatan;
                    document.getElementById('updatejumlah').value = data.jumlah;
                    jQuery('#updateModalObat').modal('show'); // Menampilkan modal   
            }
        };

        xhr.onerror = function() {
            alert('Request failed');
        };
    }
    function submitUpdateFormObat(id, id_rm) {
        let data = {
            id: id,
            id_rm: id_rm,
            sku: document.getElementById('updatesku').value,
            label_catatan: document.getElementById('updatelabelcatatan').value,
            jumlah: document.getElementById('updatejumlah').value
        };

        let xhr = new XMLHttpRequest();
        
        xhr.open('PUT', `http://192.168.78.114/silk2024-slim-main/public/rawatjalan/obat/${id}/${id_rm}`);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status != 200) {
                alert(`Error ${xhr.status}: ${xhr.statusText}`);
            } else {
                alert('Data berhasil diupdate ✅');
                $('#updateModalObat').modal('hide'); // Menyembunyikan modal setelah update
                get_rawatjalan(); // Memuat ulang data setelah update
            }
        };

        xhr.onerror = function() {
            alert('Request failed');
        };

        xhr.send(JSON.stringify(data));
    }

//HAPUS

    function delete_rawatjalan(id,sku) {
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', `http://192.168.78.114/silk2024-slim-main/public/rawatjalan/delete/${id}/${sku}`);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status != 200 && xhr.status != 204) {
                alert(`Error ${xhr.status}: ${xhr.statusText}`);
            } else {
                alert('Data berhasil dihapus');
                get_rawatjalan(); // Memuat ulang data setelah penghapusan
            }
        };

        xhr.onerror = function() {
            alert('Request failed');
        };

        xhr.send();
        }

// cari obat
    function cariObat(sku) {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', `http://192.168.78.114/silk2024-slim-main/public/cari_obat/${sku}`);
            xhr.send();

            xhr.onload = function() {
                if (xhr.status != 200) {
                    alert(`SKU tidak ada di data Obat farmasi ⛔`);
                } else {
                    alert(`SKU ada di data Obat farmasi ✅`);
                    document.getElementById('updateNamaObat').value = data.nama_obat;                    
                    document.getElementById('updatesku').value = data.sku;

                }
            };

            xhr.onerror = function() {
                alert('Request failed');
            };
            
        }

        
 
 

        window.onload = get_rawatjalan; // Memanggil get_rawatjalan() agar data muncul saat halaman pertama kali dimuat

</script>

</head>

<body>
    <!-- Modal Rekam Medis -->
    <div class="modal fade" id="updateModalRM" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Data Rekam Medis Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="RM">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="updateId_RM">ID RM:</label>
                                    <input type="text" class="form-control" id="updateId_RM" name="updateId_RM" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="updateKeluhan">Keluhan:</label>
                                    <input type="text" class="form-control" id="updateKeluhan" name="keluhan" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="updateTinggi">Tinggi:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="updateTinggi" name="tinggi" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Cm</span>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="form-group">
                                    <label for="updateDokter">Dokter:</label>
                                    <input type="text" class="form-control" id="updateDokter" name="dokter" readonly>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="updateNoRm">No RM:</label>
                                    <input type="text" class="form-control" id="updateNoRm" name="updateNoRm" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="updateTensi">Tensi:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="updateTensi" name="tensi" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">mm Hg</span>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="form-group">
                                    <label for="updateBerat">Berat:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="updateBerat" name="berat" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="form-group">
                                    <label for="updateStatus_obat">Status Obat:</label>
                                    <input type="text" class="form-control" id="updateStatus_obat" name="status_obat" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="updateTanggal">Tanggal:</label>
                                    <input type="text" class="form-control" id="updateTanggal" name="tanggal" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    {{-- <button type="button" class="btn btn-primary" onclick="submitUpdateFormTindakan(document.getElementById('updateId').value,document.getElementById('updateId_RM').value)">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Update Tindakan -->
    <div class="modal fade" id="updateModalTindakan" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Tindakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateFormTindakan">
                        <input type="hidden" id="updateId" name="id">
                        <input type="hidden" id="updateIDRM" name="updateIDRM">
                        <div class="form-group">
                            <label for="updateNo_Rm">No RM:</label>
                            <input type="text" class="form-control" id="updateNo_Rm" name="updateNo_Rm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="updateTindakan">Tindakan:</label>
                            <input type="text" class="form-control" id="updateTindakan" name="tindakan">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUpdateFormTindakan(document.getElementById('updateId').value,document.getElementById('updateIDRM').value)">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Update Obat --}}
    <div class="modal fade" id="updateModalObat" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                <input type="hidden" id="updateid" name="id">
                <div class="form-group">
                    <label for="updateid_rm">Id Rm:</label>
                    <input type="text" class="form-control" id="updateid_rm" name="updateid_rm" readonly>
                </div>

                <div class="form-group">
                    <label for="updatesku">SKU:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="updatesku" name="updatesku">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="cariObatBtn" onclick="cariObat(document.getElementById('updatesku').value)">Cari Obat</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="updateNamaObat">Nama Obat:</label>
                    <input type="text" class="form-control" id="updateNamaObat" name="updateNamaObat" readonly>
                </div>

                <div class="form-group">
                    <label for="updatelabelcatatan">Label Catatan:</label>
                    <input type="text" class="form-control" id="updatelabelcatatan" name="updatelabelcatatan">
                </div>
                <div class="form-group">
                    <label for="updatejumlah">Jumlah:</label>
                    <input type="text" class="form-control" id="updatejumlah" name="updatejumlah">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="delete_rawatjalan(document.getElementById('updateid').value , document.getElementById('updatesku').value)">Hapus</button>
                <button type="button" class="btn btn-primary" onclick="submitUpdateFormObat(document.getElementById('updateid').value , document.getElementById('updateid_rm').value)">Save changes</button>
            </div>
            </div>
        </div>
    </div>

{{-- TABEL DATA RAWAT JALAN --}}
    <div class="relative">
        <h1 class="text-center">Rawat Jalan</h1>
        <table class="table mx-auto w-75" id="outputTable">
            <thead>
                <tr>
                    <th>ID RM</th>
                    <th>No RM</th>
                    <th>Nama</th>
                    <th>Tindakan yang dilakukan dokter</th>
                    <th>SKU</th>
                    <th>Obat yang diberikan</th>
                    <th>Jumlah</th>
                    <th>Catatan tambahan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan diisi oleh JavaScript -->
            </tbody>
        </table>
    </div>

<!-- Memulai Footer -->
    <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-center">
                
        <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
            Create By Maria & Apfia
        </div>
    </div>

</body>
</html>

@endsection   