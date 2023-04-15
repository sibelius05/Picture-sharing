<?php
if (empty($_SESSION['auswahl']))
{
?>
<div id="menue">
    <p>
        <span class="invis">Rubrikmen&uuml;<br /></span>
    </p>
    <ul>
        <li>
            <a href="index.php?id=1" title="Info gesamt"><dfn><span class="hier">2:</span></dfn>neue Suche</a><span class="invis">.</span>
        </li>
<!--        <li>
            <a href="index.php?id=2" title="Info gesamt"><dfn><span class="hier">2:</span></dfn>Einrichtungen/Ämter</a><span class="invis">.</span>
        </li>
        <li>
            <a href="index.php?id=3" title="Info gesamt"><dfn><span class="hier">4:</span></dfn>Ärzte</a><span class="invis">.</span>
        </li>
        <li>
            <a href="index.php?id=4" title="Info gesamt"><dfn><span class="hier">5:</span></dfn>Therapeuten</a><span class="invis">.</span>
        </li>
        <li>
            <a href="index.php?id=5" title="Info gesamt"><dfn><span class="hier">7:</span></dfn>Angehörige</a><span class="invis">.</span>
        </li>
-->        <li>
            <a href="index.php" title="Info gesamt"><dfn><span class="hier">10:</span></dfn>Abmelden</a><span class="invis">.</span>
        </li>
    </ul>
</div>
<?php
}
else
{
?>
<div id="menue">
    <p>
        <span class="invis">Rubrikmenü<br /></span>
    </p>
    <ul>
        <li>
            <a href="index.php?id=1" title="Info gesamt"><dfn><span class="hier">1:</span></dfn>neue Suche</a><span class="invis">.</span>
        </li>
        <li>
            <a href="index.php?id=7" title="Info gesamt"><dfn><span class="hier">1:</span></dfn>Stammdaten</a><span class="invis">.</span>
        </li>
        <!--        <li>
            <a href="index.php?id=11" title="Info gesamt"><dfn><span class="hier">7:</span></dfn>Ärzte</a><span class="invis">.</span>
        </li>
        <li>
                    <a href="index.php?id=8" title="Info gesamt"><dfn><span class="hier">3:</span></dfn>Erkrankung</a><span class="invis">.</span>
                </li>
                <li>
                    <a href="index.php?id=9" title="Info gesamt"><dfn><span class="hier">4:</span></dfn>Patientenakte</a><span class="invis">.</span>
                </li>
                <li>
                    <a href="index.php?id=10" title="Info gesamt"><dfn><span class="hier">5:</span></dfn>Einrichtungen/Ämter</a><span class="invis">.</span>
                </li>
                <li>
                    <a href="index.php?id=12" title="Info gesamt"><dfn><span class="hier">8:</span></dfn>Therapeuten</a><span class="invis">.</span>
                </li>
                <li>
                    <a href="index.php?id=13" title="Info gesamt"><dfn><span class="hier">10:</span></dfn>Angehörige</a><span class="invis">.</span>
                </li>
        -->        <li>
            <a href="index.php" title="Info gesamt"><dfn><span class="hier">12:</span></dfn>Abmelden</a><span class="invis">.</span>
        </li>
    </ul>
</div>
<?php
}
?>