# dyndns_home
Home made dyndns service based on dnsmasq (resolver), php/httpd (registering server) and curl (registering client)

You don't have control over DHCP and/or dns and want your vms to be accesible by name?
Want to skip the hurdle of associating MACs with ips in DHCP or similar hurdles for the random MACs of vms?
Just use a local dns resolver (that can also do caching) in a minimal cpu/memory print

1. Configure dnsmasq
1.1 Have in dnsmasq config the following :
Have /etc/resolv_dnsmasq.conf contain a local resolver (optional) and some global ones (8.8.8.8) :
resolv-file=/etc/resolv_dnsmasq.conf
strict-order # parse /etc/resolv.conf in order
conf-dir=/etc/dnsmasq.d # parse declarations in this director. !!! N.B.!!! to be writeable by http (see step 3) make it root:apache 775

1.2 have in /etc/resolv.conf :
nameserver 127.0.0.1

one could add other backup nameservers (in case the local dnsmasq is not running)

2. Make sure dnsmasq is restarted each time content of /etc/dnsmasq.d is modified - only for systemd
see dnsmasq_restarter.path and dnsmasq_restarter.service

3. Serve by a php enabled server the contents of www_html_dnsmasq :
a php that writes a pair of name/ip in /etc/dnsmasq.d (the regex should validate the hostname)
and an necessary .htacess (no one wants headaches - the included one have format for apache 2.4)

4. Have on clients/vms/kickstarted machines a NetworkManager dispatcher that updates the current taken ip
NetworkManager_dispatcher.d/30-regip (/etc/NetworkManager/dispatcher.d/30-regip)

if vm/kickstarted machine have multiple ips, curl have the option "--interface" that takes either an interface name or an ip.

