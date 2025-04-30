
<html>
    <head>
        <title>Student Certificate</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset="UTF-8">
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: 'kalpurush', sans-serif;
                background: #fff;
            }

            table {
                width: 900px;
                height: 842px; /* roughly A4 height */
                border-collapse: collapse;
                margin: auto;
            }

            /* td {
                vertical-align: middle;
                text-align: center;
                padding: 5px;
            } */

            /* Prevent page break inside table */
            @media print {
                table, tr, td {
                    page-break-inside: avoid !important;
                }

                * {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                /* @page {
                    size: A4 portrait;
                    margin: 0;
                } */
            }
            </style>

    </head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="height: 100vh; width: 100%;">
<!-- Save for Web Slices (V1-1.psd) -->
<table id="Table_01" width="3580" height="2552" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="14">
			<img src="{{ asset('Backend/images/V2_01.png') }}" width="3579" height="1234" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="1234" alt=""></td>
	</tr>

	<tr>
		<td rowspan="16">
			<img src="{{ asset('Backend/images/V2_02.png') }}" width="204" height="1317" alt=""></td>
		<td colspan="12" style="text-align: center; font-family: 'Montserrat', sans-serif; font-size: 100px; font-weight: bolder; color: black; background-image: url('{{ asset('Backend/images/certificate_background.png') }}'); background-size: cover; background-repeat: repeat;">
            <p> {{ strtoupper($student->name) }} </p>

        </td>
		<td rowspan="16">
			<img src="{{ asset('Backend/images/V2_04.png') }}" width="205" height="1317" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="124" alt=""></td>
	</tr>
	<tr>
		<td colspan="12">
			<img src="{{ asset('Backend/images/V2_05.png') }}" width="3170" height="9" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="9" alt=""></td>
	</tr>
	<tr>
		<td colspan="12" style="text-align: center; font-family: 'Montserrat', sans-serif; font-size: 80px; font-weight: bold; color: #b58803; background-image: url('{{ asset('Backend/images/certificate_background.png') }}'); background-size: cover; background-repeat: no-repeat;   text-transform: uppercase;">
           <p>S/O: {{ strtoupper($student->father_name) }} </p>

        </td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="113" alt=""></td>
	</tr>
	<tr>
		<td colspan="12">
			<img src="{{ asset('Backend/images/V2_07.png') }}" width="3170" height="7" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="7" alt=""></td>
	</tr>
	<tr>
		<td colspan="12"  style="text-align: center; font-family: 'Montserrat', sans-serif; font-size: 70px; font-weight: bold; color: #b58803; background-image: url('{{ asset('Backend/images/certificate_background.png') }}'); background-size: cover; background-repeat: no-repeat;">

            <p>PASSPORT: {{ strtoupper($student->nid_or_passport  ?? 'N/A') }} </p>
        </td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="101" alt=""></td>
	</tr>
	<tr>
		<td colspan="12">
			<img src="{{ asset('Backend/images/V2_09.png') }}" width="3170" height="38" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="38" alt=""></td>
	</tr>
	<tr>
		<td colspan="7">
			<img src="{{ asset('Backend/images/V2_10.png') }}" width="1768" height="109" alt="">
        </td>

		<td colspan="2" rowspan="2" style="text-align: center; font-family: 'Montserrat', sans-serif; font-size: 84px; font-weight: bold; color: #181201; background-image: url('{{ asset('Backend/images/certificate_background.png') }}'); background-size: cover; background-repeat: no-repeat;">
            <p>{{ strtoupper($student->course_duration  ?? 'N/A') }} </p>
        </td>

		<td colspan="3" rowspan="2">
			<img src="{{ asset('Backend/images/V2_12.png') }}" width="1237" height="117" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="109" alt=""></td>
	</tr>
	<tr>
		<td rowspan="9">
			<img src="{{ asset('Backend/images/V2_13.png') }}" width="127" height="816" alt=""></td>
		<td colspan="3" rowspan="2" style="text-align: right; font-family: 'Montserrat', sans-serif; font-size: 84px; font-weight: 800; color: #181201; background-image: url('{{ asset('Backend/images/certificate_background.png') }}'); background-size: cover; background-repeat: no-repeat;">
            <p>{{ $student->course_end ? strtoupper(date('d M Y', strtotime($student->course_end))) : 'N/A' }}</p>

        </td>
		<td colspan="3">
			<img src="{{ asset('Backend/images/V2_15.png') }}" width="800" height="8" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="8" alt=""></td>
	</tr>
	<tr>
		<td rowspan="8">
			<img src="{{ asset('Backend/images/V2_16.png') }}" width="40" height="808" alt=""></td>
		<td colspan="7" style="text-align: left; font-family: 'Montserrat', sans-serif; font-size: 80px; font-weight: 800; color: #181201; background-image: url('{{ asset('Backend/images/certificate_background.png') }}'); background-size: cover; background-repeat: no-repeat;">

            @foreach (explode(',', $student->course) as $course)
            {{ strtoupper($course) }},
        @endforeach
        {{-- {{ strtoupper($student->course) }}, --}}
        </td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="98" alt=""></td>
	</tr>
	<tr>
		<td colspan="3" rowspan="3">
			<img src="{{ asset('Backend/images/V2_18.png') }}" width="841" height="265" alt=""></td>
		<td colspan="7">
			<img src="{{ asset('Backend/images/V2_19.png') }}" width="2162" height="153" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="153" alt=""></td>
	</tr>
	<tr>
		<td rowspan="6">
			<img src="{{ asset('Backend/images/V2_20.png') }}" width="381" height="557" alt=""></td>
		<td colspan="2" rowspan="5">
			{{-- <img src="{{ asset('Backend/images/V2_21.png') }}" width="393" height="391" alt=""> --}}
            <div id="qrCodeContainer" style="width: 200px; height: 200px; margin: auto;"></div>

        </td>
		<td colspan="4">
			<img src="{{ asset('Backend/images/V2_22.png') }}" width="1388" height="6" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="5">
			<img src="{{ asset('Backend/images/V2_23.png') }}" width="517" height="551" alt=""></td>
		<td rowspan="3">
			<img src="{{ asset('Backend/images/V2_24.png') }}" width="642" height="274" alt=""></td>
		<td rowspan="5">
			<img src="{{ asset('Backend/images/V2_25.png') }}" width="229" height="551" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="106" alt=""></td>
	</tr>
	<tr>
		<td rowspan="4">
			<img src="{{ asset('Backend/images/V2_26.png') }}" width="102" height="445" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/V2_27.png') }}" width="642" height="151" alt=""></td>
		<td rowspan="4">
			<img src="{{ asset('Backend/images/V2_28.png') }}" width="97" height="445" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="151" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="{{ asset('Backend/images/V2_29.png') }}" width="642" height="294" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="17" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="{{ asset('Backend/images/V2_30.png') }}" width="642" height="277" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="111" alt=""></td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="{{ asset('Backend/images/V2_31.png') }}" width="393" height="166" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="1" height="166" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="204" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="127" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}" width="102" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="642" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="97" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="40" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="381" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="379" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="14" height="1" alt=""></td>
		<td>
            <img src="{{ asset('Backend/images/spacer.gif') }}"  width="151" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="366" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="642" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="229" height="1" alt=""></td>
		<td>
			<img src="{{ asset('Backend/images/spacer.gif') }}"  width="205" height="1" alt=""></td>
		<td></td>
	</tr>
</table>
<!-- End Save for Web Slices -->
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script type="text/javascript">
    window.print();

    const student_id = {{ $student->id }};
    
    var qrData = "{{ route('admin.student.certificate', $student->id) }}";

    var qrCodeContainer = document.getElementById('qrCodeContainer');
    QRCode.toDataURL(qrData, {
        width: 200
    }, function(err, url) {
        if (err) {
            console.error(err);
            return;
        }

        qrCodeContainer.innerHTML = `<img src="${url}" alt="QR Code" class="img-fluid">`;
    });
</script>

</body>
</html>
