// Mengatur konfigurasi mixin untuk notifikasi toast
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  },
});

// Fungsi untuk menampilkan notifikasi toast sukses
function showSuccessToast(message) {
  Toast.fire({
    icon: "success",
    title: message,
  });
}

// Fungsi untuk menampilkan notifikasi toast error
function showErrorToast(message) {
  Toast.fire({
    icon: "error",
    title: message,
  });
}

$(document).on("click", ".btn-hapus", function (e) {
  //hentikan aksi default
  e.preventDefault();
  var href = $(this).attr("href");

  Swal.fire({
    title: "Apakah anda yakin",
    text: "ingin menghapus data ini?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Hapus!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = href;
    }
  });
});
