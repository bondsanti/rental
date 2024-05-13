<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ส่ง Email</title>
</head>
<body>
    <h2>เรียนผู้เกี่ยวข้อง</h2>
    <h4>มีการแนบสลิปการจ่ายเงิน !!
        <br>โครงการ <font color="red"> {{$project}} </font> 
        <br>ห้องเลขที่ <font color="red">{{$roomNo}}</font> 
        <br>เจ้าของห้อง <font color="red">{{$owner}}</font>
        <br>ประจำเดือน <font color="red">{{ thaidate('F Y', $monthY) }}</font>
        <br>จากระบบ Rental </h4>
    <h4>กรุณาตรวจสอบความถูกต้อง และอนุมัติการจ่าย</h4>
    <h2><a href="{{$Link}}" target="_blank">คลิ๊กเพื่ออนุมัติ</a></h2>
</body>
</html>
