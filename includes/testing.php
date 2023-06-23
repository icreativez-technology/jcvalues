<script>
	    $(document).ready(function(){
			$.get(`print-mtc.php?id=${id}&mode=${mode}`, function(data) {
                let opt = {
                    margin: [0.1, 0.1, 0.1, 0.1],
                    image: {
                        type: "jpeg",
                        quality: 1.5,
                    },
                    html2canvas: {
                        // scale: 7,
                        scale: 3,
                        // letterRendering: false,
                        letterRendering: true,
                        dpi: 300,
                        width: 783,
                        scrollY: 0,
                    },
                    jsPDF: {
                        unit: "in",
                        format: "A4",
                        orientation: "portrait",
                        // orientation: "landscape",
                    },
                };
                let worker = html2pdf().set(opt).from(data).save(fileName);
            });
		})
</script>