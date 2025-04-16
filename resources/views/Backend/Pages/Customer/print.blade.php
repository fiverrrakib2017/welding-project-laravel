<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <style>
    @media print {
      body {
        width: 80mm;
        font-family: 'Courier New', monospace;
        font-size: 12px;
      }

      .invoice {
        padding: 5px;
      }

      .center {
        text-align: center;
      }

      .line {
        border-top: 1px dashed #000;
        margin: 5px 0;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      td {
        padding: 2px 0;
      }

      .right {
        text-align: right;
      }

      .bold {
        font-weight: bold;
      }
    }
  </style>
</head>
<body>
  <div class="invoice">
    <div class="center bold">My Shop</div>
    <div class="center">123, Dhaka, Bangladesh</div>
    <div class="center">Phone: 017xxxxxxxx</div>

    <div class="line"></div>

    <div>Date: 2025-04-16</div>
    <div>Invoice: #INV123456</div>

    <div class="line"></div>

    <table>
      <thead>
        <tr>
          <td>Item</td>
          <td class="right">Qty</td>
          <td class="right">Price</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Rice</td>
          <td class="right">2</td>
          <td class="right">100</td>
        </tr>
        <tr>
          <td>Oil</td>
          <td class="right">1</td>
          <td class="right">120</td>
        </tr>
        <tr>
          <td>Sugar</td>
          <td class="right">1</td>
          <td class="right">80</td>
        </tr>
      </tbody>
    </table>

    <div class="line"></div>

    <table>
      <tr>
        <td class="bold">Total</td>
        <td class="right bold">Tk 300</td>
      </tr>
      <tr>
        <td>Paid</td>
        <td class="right">Tk 300</td>
      </tr>
      <tr>
        <td>Change</td>
        <td class="right">Tk 0</td>
      </tr>
    </table>

    <div class="line"></div>

    <div class="center">Thank you!</div>
    <div class="center">Visit Again</div>
  </div>
  <script>
    window.addEventListener("load", function() {
            window.print();
        });
  </script>
</body>
</html>
