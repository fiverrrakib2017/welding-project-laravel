<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Certificate</title>
    <!-- Google Font: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Montserrat', sans-serif;

            /* background-color: #efefef; */

        }

        .certificate {
            max-width: 900px;
            margin: auto;
            border: 10px solid #c19836;
            padding: 0;
            background-color: #efefef;
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }


        .certificate-inner {
            background-image: linear-gradient(135deg, #ffffff, #fdf7e9);
            padding: 30px;
        }

        /* .certificate h1, */
        .certificate h2,
        .certificate h3,
        .certificate p {
            margin: 10px 0;
            text-align: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            height: 90px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            color: #a36e00;
        }

        .address {
            font-size: 14px;
            font-weight: bold;
        }

        .certify {
            font-family: 'Great Vibes', cursive;
            font-size: 38px;
            color: #334a7d;
            text-align: center;
            margin-top: 30px;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            color: #1d1c61;
        }

        .passport {
            font-size: 16px;
            font-weight: bold;
            color: #b08500;
        }

        .details {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        .italic {
            font-style: italic;
            color: #555;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 40px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .footer .box {
            width: 30%;
            text-align: center;
        }

        .footer .label {
            border-top: 2px solid #c19836;
            padding-top: 5px;
            font-weight: bold;
            margin-top: 5px;
        }

        .qr {
            width: 80px;
            height: 80px;
            background-color: #ccc;
            display: inline-block;
        }

        /* Signature Image */
        .signature-img {
            height: 40px;
            width: 100px;
            object-fit: contain;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .certificate-inner {
                padding: 15px;
            }

            .title {
                font-size: 20px;
            }

            .certify {
                font-size: 28px;
            }

            .name {
                font-size: 20px;
            }

            .passport,
            .details,
            .italic {
                font-size: 14px;
            }

            .footer {
                flex-direction: column;
                align-items: center;
            }

            .footer .box {
                width: 100%;
                margin-bottom: 20px;
            }

            .qr {
                margin: 20px 0;
            }

            .signature-img {
                width: 80px;
                height: auto;
            }

            .reg-no {
                position: absolute;
                font-size: 16px;
                font-weight: bold;
                color: #dd1212;
                padding: 6px 10px;
                /* border-radius: 5px; */
                font-family: 'Montserrat', sans-serif;
                /* z-index: 10; */
            }
            .logo img {
                margin-top: 15px;
            }
        }

        @media print {
            .no-print {
                display: none;
            }
        }


        .reg-no {
            position: absolute;
            font-size: 16px;
            font-weight: bold;
            color: #070707;
            padding: 6px 10px;
            /* border-radius: 5px; */
            font-family: 'Montserrat', sans-serif;
            /* z-index: 10; */
        }
    </style>
</head>

<body>

    <div class="certificate">
        <div class="reg-no">
            <strong>REGISTRATION NO:</strong><br>  {{ $student->reg_no ?? 'N/A' }}
        </div>
        <div class="certificate-inner">
            <div class="logo">
                <img src="{{ asset('Backend/images/logo.png') }}" alt="Logo" />
            </div>
            <h1 class="title" style="font-size: 32px; font-weight: bolder; text-align: center">ANIK WELDING TECHNICAL
                TRAINING CENTER</h1>
            <h3 class="address">398 SHADINATA SARANI, NORTH BADDA, DHAKA-1212, BANGLADESH</h3>
            <p class="certify">This is to certify that</p>
            <h2 class="name"> {{ strtoupper($student->name) }}</h2>
            <p class="passport">S/O:{{ strtoupper($student->father_name) }}<br>PASSPORT:
                {{ strtoupper($student->nid_or_passport ?? 'N/A') }}</p>
            <p class="details">HAS SUCCESSFULLY COMPLETED {{ strtoupper($student->course_duration ?? 'N/A') }} MONTHS
                COURSE ON<br>
                {{ $student->course_end ? strtoupper(date('d M Y', strtotime($student->course_end))) : 'N/A' }} -  @foreach (explode(',', $student->course) as $course)
                        {{ strtoupper($course) }}@if (!$loop->last), @endif
                        @endforeach
                </p>
            <p class="italic" style="font-family: 'Great Vibes', cursive; color:#334a7d; font-size:30px;">at our training center.</p>

            <div class="footer">
                <div class="box">
                    <div id="current-date">25 Jun 2025</div>
                    <div class="label">DATE</div>
                </div>

                <div class="qr" id="qr"></div>

                <div class="box">
                    @php
                        if(!empty($student->user_id)){
                            $signature = \App\Models\Signature::where('user_id',$student->user_id)->where('status','1')->first();
                        }
                    @endphp
                @if(!empty($signature))
                    <img src="{{ asset('Backend/uploads/photos/'.$signature->name) }}" alt="Signature" class="signature-img">
                @else
                    <img src="https://th.bing.com/th/id/R.1586d36732fcb856523df8789b146070?rik=%2bEbvkKcvSuyOiw&riu=http%3a%2f%2fclipart-library.com%2fimages%2fBTarnpzpc.png&ehk=PxwN8kkbSi%2fIx4%2buzMLpDi%2bZX5YH59a1GTuIyrZ8ZoE%3d&risl=&pid=ImgRaw&r=0"
                alt="Signature" class="signature-img">
                @endif
                    <div class="label">SIGNATURE</div>
                </div>
            </div>


        </div>
        <div class="extra no-print">
            <button onclick="window.print()">Print</button>
            <button onclick="downloadPDF()">Save</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script type="text/javascript">
        var qrData = @json(route('admin.student.certificate', $student->id));
        var qrCodeContainer = document.getElementById('qr');
        QRCode.toDataURL(qrData, {
            width: 200
        }, function(err, url) {
            if (err) {
                console.error(err);
                return;
            }

            qrCodeContainer.innerHTML = `<img src="${url}" style="width:100%;" alt="QR Code" class="img-fluid">`;
        });


        function downloadPDF() {
            const buttons = document.querySelectorAll('.no-print');
            const element = document.querySelector(".certificate");

            buttons.forEach(btn => btn.style.display = 'none');

            const opt = {
                margin: 0.5,
                filename: 'certificate.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'landscape'
                }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                buttons.forEach(btn => btn.style.display = '');
            });
        }

        const today = new Date();
        const formattedDate = today.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        document.getElementById('current-date').innerText = formattedDate;
    </script>
</body>

</html>
