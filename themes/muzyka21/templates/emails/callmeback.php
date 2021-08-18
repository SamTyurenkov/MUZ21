<!DOCTYPE html>
<html>

<head>
    <base target="_blank">
</head>

<body>
    <table width="100%" border="0">
        <td align="center" style="background:#f2f2f2;width:100%">
            <div id="brand" style="font-size:20px;line-height:80px;text-align:center;color: #d03030;font-weight: 800">MUSIC XXI</div>
            <div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto">
                <table width="88%">
                <div id="headerimage" style="width:100%;height:300px;background:url('<?php echo $args['domain']; ?>/wp-content/themes/muzyka21/images/banners/musicxxibanner.png')no-repeat center center;background-size:cover"></div>
                <div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">
                        <h2>Заявка с сайта</h2>
                        <p>Посетитель <b><?php echo $args['username']; ?></b> с сайта просит связаться с ним для консультации.</p>
                        <p>Email: <?php echo $args['email']; ?> | Телефон: <?php echo $args['phone']; ?></p>
                        <p>Страница с которой отправлен запрос: <a href="<?php echo $args['page']; ?>"><?php echo $args['page']; ?></a></p>
                    </div>
                </table>
            </div>
            <table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table>
        </td>
    </table>
</body>

</html>