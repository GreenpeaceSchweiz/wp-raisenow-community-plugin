# Infrastrukur

## Webserver <a id="Infrastruktur-Webserver"></a>

### Greenpeace.ch

Die Infrastruktur für die Webseite greenpeace.ch wird von GPI betrieben. Im Störungsfall ist die globale IT zuständig: [global-it@greenpeace.org](mailto:global-it@greenpeace.org)

### Shared Hosting weitere Webseiten <a id="Infrastruktur-SharedHostingweitereWebseiten"></a>

Der Server mc16e0906.dnh.net wird von Metanet betrieben. Darauf liegen diverse Webseiten.

Verwaltung über Plesk: [https://mc16e0906.dnh.net:8443](https://mc16e0906.dnh.net:8443)

Kontakt/Support über: [https://www.metanet.ch/support/support-anfragen](https://www.metanet.ch/support/support-anfragen)

### Scaleway <a id="Infrastruktur-Scaleway"></a>

Von Zeit zu Zeit betreiben wir bei Scaleway Testserver oder Server für Seiten, welche nicht über ein Shared Hosting betrieben werden können. Auch bei Scaleway wird der Server für [https://mastodon.greenpeace.ch/](https://mastodon.greenpeace.ch/) betrieben.

## DNS <a id="Infrastruktur-DNS"></a>

Wir benutzen DNS Cloud, betrieben von Metanet: [https://dns.sui-inter.net/](https://dns.sui-inter.net/l)

Die Domain greenpeace.ch wird über [Cloudflare ](https://dash.cloudflare.com/)verwaltet. Wer für welche Einträge verantwortlich ist, [steht in diesem Google Sheet](https://docs.google.com/spreadsheets/d/1OirbvxSWrmpqyXmrc_kWAlGK4DlcTasDBLH55wCPGT4/edit?usp=sharing).



Greenpeace Schweiz hat um die 120 Domains registriert, Bestand stark schwankend.

## Domains

### Domain-Registrationen

Für die Suche nach freien Domains, unbedingt eine Seite mit gutem Ruf benutzen. Es gibt dienste die versuchen, eine Domain zu registrieren nachdem sie gesucht wurde, um sie dann teuer zu verkaufen. Eine gute Suchfunktion bietet [https://www.gandi.net/](https://www.gandi.net/en)

#### [Wem gehört eine Domain?](https://www.gandi.net/en) <a id="Domains-Wemgeh&#xF6;rteineDomain?"></a>

[Whois-Daten können bei verschiedenen Webdiensten abgefragt werden. Da wird meistens auch angezeigt, wem eine Domain gehört. Es gibt aber auch Domains, die anonymisiert sind.](https://www.gandi.net/en)

[Hier können Whois-Daten abgefragt werden:](https://www.gandi.net/en) [http://whois.domaintools.com](http://whois.domaintools.com)

### Liste aller registrierten Domains <a id="Domains-ListeallerregistriertenDomains"></a>

Es gibt noch keine vollständige Liste aller Domains. In Arbeit ist eine Liste vorläufig in der Server-Datei hier:

[https://greenpeace.box.com/s/edz65lieq8eurjzkvrkdr7r67dree4mm](https://greenpeace.box.com/s/edz65lieq8eurjzkvrkdr7r67dree4mm)

Das Passwort ist in 1Password in der Notiz _Server-Datei Hosting GPCH_

### Domains mit spezieller Konfiguration <a id="Domains-DomainsmitspeziellerKonfiguration"></a>

**peoplepower.ch**

DNS für die Hauptdomain geht auf unseren Shared Server 46.231.204.165. Dort wird umgeleitet auf [www.peoplepower.ch.](http://www.peoplepower.ch.) Für die Subdomain www ist gemäss der [Anleitung von Controlshift Labs](https://controlshiftlabs.zendesk.com/hc/en-us/articles/203532437-Domain-Name-Setup) ein CNAME-Eintrag auf platform.controlshiftlabs.com eingetragen.

### Registrare <a id="Domains-Registrare"></a>

Alle Domains sind bei drei verschiedenen Diensten registriert. Zugänge sind im 1Password im Infrastruktur-Tresor.

* [Checkdomain.de](https://www.checkdomain.de/): Enthält die meisten Domains. Guter Dienst, für .ch-Domains allerdings etwas teuer.
* [Switchplus](https://www.switchplus.ch/): Wurde lange Zeit ausschliesslich für .ch-Domains benutzt, als Nachfolger für Switch. Allerdings ist die Sicherheit fragwürdig \(per Telefon kann alles ohne vernünftige Identifikation geändert werden\), die Bezahlung ist mühsam \(jede Domain einzeln\), technisch ist die Oberfläche völlig veraltet.
* [Gandi.net](https://www.gandi.net/en): Zuverlässiger Dienst mit günstigen Preisen. Eigener DNS-Server und Webmail falls nötig \(obwohl wir trotzdem standardmässig unsere eigenen Server verwenden\). Neuere .ch-Domains sind hier registriert.

