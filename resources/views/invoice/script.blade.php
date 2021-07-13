
<script src="{{ asset('assets/modules/jquery.min.js') }} "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script>
    $(document).ready(function () {
        genScreenshot();


        function genScreenshot() {

            var HTML_Width = $("#boxes").width();
            var HTML_Height = $("#boxes").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;


            html2canvas($("#boxes")[0], {allowTaint: true}).then(function (canvas) {
                canvas.getContext('2d');
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);

                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    console.log(top_left_margin + "  " + (-(PDF_Height * i) + (top_left_margin)));
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin), canvas_image_width, canvas_image_height);
                }

                pdf.setProperties({
                    title: "{{$invoice->invoice_id}}"
                });
                var string = pdf.output('datauristring');
                var iframe = "<iframe width='100%' height='100%' src='" + string + "' frameborder='0'></iframe>"
                document.write(iframe);
            });
            // return;
        }
    });
</script>
