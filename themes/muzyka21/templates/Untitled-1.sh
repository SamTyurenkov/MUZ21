#!/bin/bash
cloudflare_real_ip_conf="/etc/nginx/conf.d/cloudflare/cloudflare_ip.conf";
ip4 = $(curl -sk https://www.cloudflare.com/ips-v4);
ip6 = $(curl -sk https://www.cloudflare.com/ips-v6);

echo "#Cloudflare" > $cloudflare_real_ip_conf;
for i in $ip4; do
        echo "set_real_ip_from $i;" >> $cloudflare_real_ip_conf;
done
for i in $ip6; do
        echo "set_real_ip_from $i;" >> $cloudflare_real_ip_conf;
done

echo "" >> $cloudflare_real_ip_conf;
echo "# use any of the following two" >> $cloudflare_real_ip_conf;
echo "real_ip_header CF-Connecting-IP;" >> $cloudflare_real_ip_conf;
echo "#real_ip_header X-Forwarded-For;" >> $cloudflare_real_ip_conf;
