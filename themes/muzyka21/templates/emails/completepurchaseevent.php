<!DOCTYPE html>
<html>

<head>
    <base target="_blank">
</head>

<body>
    <table width="100%" border="0">
        <td align="center" style="background:#222;width:100%">
            <div id="brand" style="color:#fff;font-size:20px;line-height:80px;text-align:center">MUSIC XXI</div>
            <div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto">
                <table width="88%">
                    <div id="headerimage" style="width:100%;height:300px;background:url(<?php echo $args['image']; ?>) no-repeat center center;background-size:cover"></div>
                    <div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">
                        <h2>Билет приобретен</h2>
                        <p>Это письмо - подтверждение приобретения билета на сайте MUSIC XXI</p>
                        <p>Событие: <?php echo $args['post_id']; ?></p>
                        <p>Номер заказа: <?php echo $args['post_id']; ?></p>
                    </div>
                </table>
            </div>
            <table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table>
        </td>
    </table>
</body>

</html>