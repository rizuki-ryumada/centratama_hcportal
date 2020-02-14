$(document).ready(function() {
	$("#jenis").change(function() {
		var id = $(this).val();

		$.ajax({
			url: "http://192.168.23.51/hc_system/nomor/getSub",
			// url: "http://192.168.23.51/hc_uptothesky/nomor/getSub",
			method: "POST",
			data: {
				jenis: id
			},
			async: true,
			dataType: "json",
			success: function(data) {
				var html = "";
				var i;
				for (i = 0; i < data.length; i++) {
					html +=
						"<option value=" +
						data[i].tipe_surat +
						">" +
						data[i].tipe_surat +
						"</option>";
				}
				$("#tipe").html(html);
			}
		});
		return false;
	});
});



$(document).ready(function() {
	$("#entity").change(function() {
		var entity = $("#entity").val();
		var jenis = $("#jenis").val();
		var sub = $("#tipe").val();
		var isi = "";

		$.ajax({
			url: "http://192.168.23.51/hc_system/nomor/lihatnomor/",
			// url: "http://192.168.23.51/hc_uptothesky/nomor/lihatnomor/",
			method: "POST",
			data: {
				jenis : jenis,
				entity: entity,
				sub: sub
			},
			async: true,
			dataType: "json",
			success: function(data) {
				isi =
					data.no +
					"/" +
					data.entity +
					"-HC/" +
					data.sub +
					"/" +
					data.bulan +
					"/" +
					data.tahun;
				$(".hasil").val(isi);
			}
		});
	});
});
