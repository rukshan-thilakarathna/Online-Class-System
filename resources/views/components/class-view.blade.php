
<?php
$data = json_decode($name, true);

?>

<section id='zse1' style="background:url( @if($data['image'] != null){{ asset($data['image'])}} @else  {{ asset('/images/class-b/1.jpg') }} @endif);background-size:cover">
    <h1 ><?php echo $data['name'] ?></h1>
    <h2 ><?php echo $data['slug'] ?></h2>
</section>

<section id='zse2' style="margin-bottom: 10px">
    <p><?php echo $data['description'] ?></p>
</section>

