<?php
//document.querySelectorAll('[id^="button_"]').forEach(box => {
//    box.addEventListener('click', sendActivationMail);
//});

ini_set('display_errors', 1);

spl_autoload_register(/**
 * @param $className
 */ function ($className)
{
    include '../class/' . $className . '.php';
});

include '../config.php';

session_start();

header("Content-Type: text/javascript;charset=UTF-8: PASS");

$case = $_GET['param'] ?? '';

if ($case === 'registrations' || $case === "activatePictures" || $case === "album")
{
?>
function ajax(url, container, formData, callback = null)
{
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (http != null)
    {
        http.open("POST", "/" + url, true);
        http.onreadystatechange = function ()
        {
            if (http.readyState == 4)
            {
                var getText = http.responseText;
                document.getElementById(container).innerHTML = getText;

                if (callback != null)
                {
                    callback(formData);
                }
            }
        }
        http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        let asString = objectToQueryString(formData);

        http.send(asString);
    }
}

function objectToQueryString(obj) {
    let str = [];
    for (let p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

<?php } if ($case === 'confirm') { ?>
function init()
{
    document.querySelectorAll('#passwort1, #passwort2').forEach(box => {
        box.addEventListener('keyup', proofPassword);
    });

    let zi = /[0-9]/g;

    let klein = /[a-z]/;

    let gross = /[A-Z]/;

    let spezial = /[<?php echo SPECIAL_CHARS; ?>]/g;

    let all = /[0-9a-zA-Z<?php echo SPECIAL_CHARS; ?>]/g;

    generatePassword();

    function proofPassword()
    {
        console.clear();

        let text = this.value;

        let found1 = text.match(zi);

        let found2 = text.match(klein);

        let found3 = text.match(gross);

        let found4 = text.match(spezial);

        let found5 = text.match(all) ?? [];

        console.log(found5.length);

        if (text.length > 9 && text.length == found5.length && found1 && found2 && found3 && found4)
        {
            document.getElementById('zahl').className = 'fw-bold text-success';
            document.getElementById('erlaubt').className = 'fw-bold text-success';
            document.getElementById('ziffern').className = 'fw-bold text-success';
            document.getElementById('klein').className = 'fw-bold text-success';
            document.getElementById('gross').className = 'fw-bold text-success';
            document.getElementById('spezial').className = 'fw-bold text-success';

            if (document.getElementById('passwort1').value != document.getElementById('passwort0').value && document.getElementById('passwort1').value == document.getElementById('passwort2').value)
            {
                document.getElementById('button').removeAttribute('disabled');
            }
            else
            {
                document.getElementById('button').setAttribute('disabled', '');
            }
        }
        else
        {
            if (text.length <= 9) {document.getElementById('zahl').className = 'fw-bold text-danger'} else {document.getElementById('zahl').className = 'fw-bold text-success'}
            if (text.length != found5.length) {document.getElementById('erlaubt').className = 'fw-bold text-danger'} else {document.getElementById('erlaubt').className = 'fw-bold text-success'}
            if (!found1) {document.getElementById('ziffern').className = 'fw-bold text-danger'} else {document.getElementById('ziffern').className = 'fw-bold text-success'}
            if (!found2) {document.getElementById('klein').className = 'fw-bold text-danger'} else {document.getElementById('klein').className = 'fw-bold text-success'}
            if (!found3) {document.getElementById('gross').className = 'fw-bold text-danger'} else {document.getElementById('gross').className = 'fw-bold text-success'}
            if (!found4) {document.getElementById('spezial').className = 'fw-bold text-danger'} else {document.getElementById('spezial').className = 'fw-bold text-success'}
            document.getElementById('button').setAttribute('disabled', '');

        }
    }

    function generatePassword()
    {
        let chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz" + "<?php echo SPECIAL_CHARS; ?>";
        let string_length = 12;
        let randomstring = '';
        let countThem = 0;

        do
        {
            randomstring = '';

            for (let i = 0; i < string_length; i++)
            {
                let rnum = Math.floor(Math.random() * chars.length);
                randomstring += chars.substring(rnum, rnum + 1);
            }

            try
            {
                countThem = randomstring.match(spezial).length;
            }
            catch (err)
            {
                countThem = 0;
            }
        }
        while (!randomstring.match(zi) || !randomstring.match(klein) || !randomstring.match(gross) || countThem === 0 || countThem > 2);

        console.log(randomstring);
    }
}

init();

//https://www.geeksforgeeks.org/how-to-toggle-password-visibility-in-forms-using-bootstrap-icons/
/*const togglePassword = document.querySelector('#togglePassword');

const password = document.querySelector('#password');

togglePassword.addEventListener('click', () => {

    // Toggle the type attribute using
    // getAttribure() method
    const type = password
        .getAttribute('type') === 'password' ?
        'text' : 'password';

    password.setAttribute('type', type);

    // Toggle the eye and bi-eye icon
    this.classList.toggle('bi-eye');
});*/
<?php } else if ($case === 'register') { ?>
function init()
{
    document.querySelectorAll('#vorname, #nachname, #login, #email').forEach(box => {
        box.addEventListener('keyup', proofInput);
    });

    document.querySelectorAll('#vorname, #nachname, #login, #email').forEach(box => {
        box.addEventListener('change', proofInput);
    });

    let vorname = false;

    let nachname = false;

    let login = false;

    let email = false;

    function proofInput()
    {
        if (this.id == 'vorname' || this.id == 'nachname')
        {
            if (this.value.length > 2 && this.value.match(/^[A-ZäÖÜ][A-ZäÖÜa-zäöü -]{1,}$/i) == this.value)
            {
                console.log(this.value);

                (this.id == 'vorname') ? vorname = true : nachname = true;
            }
            else
            {
                (this.id == 'vorname') ? vorname = false : nachname = false;
            }
        }

        if (this.id == 'login')
        {
            if (this.value.length > 4  && this.value.match(/^[A-Za-z]{5,}$/) == this.value)
            {
                login = true;
            }
            else
            {
                login = false;
            }
        }

        if (this.id == 'email')
        {
            let value = this.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);

            if (value !== null && value[0] == this.value)
            {
                console.log(value[0] + "/" + this.value);

                email = true;
            }
            else
            {
                email = false;
            }

            console.log(email);
        }

        if (vorname & nachname & login & email)
        {
            document.getElementById('button').removeAttribute('disabled');
        }
        else
        {
            document.getElementById('button').setAttribute('disabled', '');
        }
    }
}

init();
<?php } else if ($case === 'registrations') { ?>
function init()
{
    document.querySelectorAll('button[type=btn]').forEach(box => {
        box.addEventListener('click', sendActivationMail);
    });

    function sendActivationMail()
    {
        //const formData = new FormData();
        //
        //formData.append("kat", "Groucho");
        //formData.append("dock", "Julius");
        //formData.append("ksjdf", "Maria");

        document.querySelectorAll('button[type=btn]').forEach(box => {
            box.removeEventListener('click', sendActivationMail);
        });

        let formData = { action : "sendActivationMail", id : this.id};

        ajax("actionAjax.php", "container_" + this.id, formData);
    }
}

init();
<?php } else if ($case === 'activatePictures') { ?>
function init()
{
    document.querySelectorAll('[id^="img_"]').forEach(box => {
        box.addEventListener('click', openModal)
    });

    document.querySelectorAll('[data-toggle^="activatePic_"]').forEach(box => {
        box.addEventListener('click', activatePicture)
    });
}

function activatePicture()
{
    console.log(this);

    let vars = this.dataset['toggle'].split('_');

    let state = this.dataset['state'];

    document.querySelectorAll('[id^="img_"]').forEach(box => {
        box.removeEventListener('click', openModal)
    });

    document.querySelectorAll('[data-toggle^="activatePic_"]').forEach(box => {
        box.removeEventListener('click', activatePicture)
    });

    document.querySelectorAll('.btn-primary').forEach(box => {
        box.removeEventListener('click', activatePicture)
    });

    let formData = { action : vars[0], userId : vars[1], pictureId : vars[2], state : state};

    ajax("actionAjax.php", "container0_" + vars[1] + '_' + vars[2], formData, modifyButton);
}

function openModal()
{
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
    });

    document.getElementById('img_modal').removeAttribute('src');

    let name = this.dataset['source'];

    let eventId = this.dataset['id'];

    let state = document.getElementById(eventId).dataset['state'];

    document.getElementById('exampleModal').setAttribute('style', '--bs-modal-width: 1000px;');

    let imgWidth = new ResizeObserver(entries => {
        for (let entry of entries) {
            const lb = entry.contentRect;

            let width = Math.round(lb.width) - 32;

            document.getElementById('img_modal').setAttribute('src', '/images/' + width + '/' + name);
        }
    });

    let buttonModal = document.getElementsByClassName('btn-primary')[0];

    buttonModal.setAttribute('id', eventId);

    buttonModal.setAttribute('data-toggle', 'modActivatePic_' + eventId);

    buttonModal.setAttribute('data-state', state);

    buttonModal.innerHTML = (state == 'active') ? 'Sperren' : 'Bild freischalten';

    buttonModal.addEventListener('click', activatePicture);

    let width = document.querySelector('.modal-content');

    imgWidth.observe(width);

    let modal = document.getElementsByClassName("modal")[0].style.display

    document.getElementById('exampleModalLabel').innerHTML = name;

    myModal.show();
}

function modifyButton(data = null)
{
    let button = document.getElementById(data['userId'] + '_' + data['pictureId']);

    let state = button.dataset['state'];

    document.getElementsByClassName('btn-primary')[0].dataset['state'] = state;

    document.getElementsByClassName('btn-primary')[0].innerHTML = (state === 'inactive') ? 'Bild freischalten' : 'Sperren';

    document.getElementsByClassName('btn-primary')[0].addEventListener('click', activatePicture);

    init();
}

init();
<?php } else if ($case === 'album') { ?>
function init ()
{
    document.querySelectorAll('[id^="img_"]').forEach(element => {
        element.addEventListener('click', openModal);
    });

    document.querySelectorAll('[id^="opn_"]').forEach(element => {
        element.addEventListener('click', openModal);
    });

    document.querySelectorAll('[id^="dlt_"]').forEach(element => {
        element.addEventListener('click', deletePicture);
    });

    document.querySelectorAll('[id^="imgCar_"]').forEach(element => {
        element.addEventListener('load', countPicture);
    });

    document.querySelectorAll('[id^="img_"]').forEach(element => {
        element.addEventListener('load', countPicture);
    });
}

function countPicture()
{
    let url = new URL(this.src);

    let pathname = "";

    pathname = url.pathname;

    let formData = { action : "countPicture", path : pathname };

    ajax("actionAjax.php", "txt_" + this.id.substring(4), formData);
}

function deletePicture()
{
    confirm('Dieses Bild wirklich löschen?');

    let picId = this.id.substring(4);

    let formData = { action : "fileDelete", picId : picId };

    ajax("actionAjax.php", "col_" + picId, formData);
}

function openModal()
{
    var myModal = new bootstrap.Modal(document.getElementById('exampleModalXl'), {
        keyboard: false
    });

    const carousel = document.getElementById('carouselExampleControls');

    carousel.querySelectorAll('.active').forEach(itemActive => {
        itemActive.setAttribute('class', 'carousel-item');
    });

    let itemId = 'item_' + this.id.substring(4);

    carousel.querySelector('#' + itemId).setAttribute('class', 'carousel-item active');

    myModal.show();
}

init();

let pr = 1100;

let p = 0;

let previous = 0;

let carItem = new ResizeObserver(entries => {
    const lb = entries[0].contentRect;

    console.log('lb.width = ' + lb.width);

    let carControl = document.getElementsByClassName('carousel-control-prev');

    if (typeof lb.width === 'number' && lb.width !== 0 && lb.width !== previous)
    {
        previous = lb.width;

        width = Math.round(lb.width - carControl[0].clientWidth - 32); console.log('width = ' + width);

        <?php if (empty($_SESSION)) { ?>if (width > <?php echo SIZE_VISITOR ?>) width = <?php echo SIZE_VISITOR ?>;
        <?php }
        else
        {
            if (isset($_SESSION['userId']))
            {
                $user = User::getById($_SESSION['userId']);

                $isUser = $user->isUser();

                if (!$isUser)
                { ?>if (width > <?php echo SIZE_UNACTIVE_USER ?>) width = <?php echo SIZE_UNACTIVE_USER ?>;<?php }
            }
        } ?>

        let src = '';

        let widthPic = 0;

        let ratio = 0.000;

        let minHeight = '';

        let picId = 0;

        document.querySelectorAll('[id^="loading-img_"]').forEach(loadingImg => {
            ratio = parseFloat(loadingImg.dataset['ratio']);

            if (ratio >= 1)
            {
                widthPic = width;

                minHeight = Math.round(width / ratio);
            }
            else
            {
                widthPic = Math.round(width * ratio);

                minHeight = widthPic;
            }

            loadingImg.style.minHeight = minHeight + 'px';

            let pic = loadingImg.childNodes[1];
            src = pic.dataset['source'].replace('images/source', 'images/' + widthPic);
            pic.setAttribute('src', src + '<?php echo '.' . COMPRESSION_TYPE ?>');
        });
    }
});

let prev = 0;

let ro = new ResizeObserver(entries => {
    for (let entry of entries) {
        const cr = entry.contentRect;
        if (typeof cr.width === 'number' && cr.width !== prev)
        {
            prev = cr.width;

            width = Math.round(cr.width);

            let src = '';
            document.querySelectorAll('[id^="img_"]').forEach(image => {
                src = image.getAttribute('data-source').replace('images/source', 'images/' + width);
                image.setAttribute('src', src + '<?php echo '.' . COMPRESSION_TYPE ?>');
            });
        }
    }
});

let card = document.querySelector('.card');

let carouselItem = document.querySelector('.carousel-inner');

// Observe one or multiple elements
ro.observe(card);

carItem.observe(carouselItem);
<?php } else if ($case === 'upload') { ?>
document.querySelector("#files").addEventListener("change", callPicture);

function callPicture(e)
{
    document.getElementById('result').innerHTML = '';

    let file = e.target.files[0];

    editFile(file, 0);

    var myModal = new bootstrap.Modal(document.getElementById('exampleModalXl'), {
        keyboard: false
    });

    myModal.show();
}

function editFile(file, fullresolution, x = 0, y = 0, Width = 0, Height = 0)
{
    if (file.type == "image/jpeg" || file.type == "image/png" || file.type == "image/webp")
    {
        //let fileName = file.name;

        let reader = new FileReader();

        reader.onload = function (readerEvent)
        {
            let image = new Image();

            image.onload = function ()
            {
                let widthModalBody = document.getElementsByClassName('modal-body')[0].clientWidth - 40;
                console.log('widthModalBody: ' + widthModalBody);
                let heightModalBody = document.getElementsByClassName('modal-body')[0].clientHeight - 40;
                console.log('heightModalBody: ' + heightModalBody);

                document.getElementById('slider-1').setAttribute('max', image.width);
                document.getElementById('slider-2').setAttribute('max', image.width);
                document.getElementById('slider-2').setAttribute('value', image.width);
                document.getElementById('slider-3').setAttribute('max', image.height);
                document.getElementById('slider-4').setAttribute('max', image.height);
                document.getElementById('slider-4').setAttribute('value', image.height);

                if (document.getElementById('sliderTwoValue').value == 0) document.getElementById('sliderTwoValue').value = image.width;
                if (document.getElementById('sliderFourValue').value == 0) document.getElementById('sliderFourValue').value = image.height;

                let sx = x;
                let sy = y;
                let sWidth = (Width && x) ? Width - x : image.width;
                let sHeight = (Height && y) ? Height - y : image.height;

                document.getElementById('range2').innerHTML = Number(sWidth) + Number(x);
                document.getElementById('range4').innerHTML = Number(sHeight) + Number(y);

                let fact = Math.sqrt(sWidth * sHeight / <?php echo RESOLUTION_UPLOADS ?>);

                dWidth = Math.round(sWidth / fact);
                dHeight = Math.round(sHeight / fact);

                if (fullresolution == 0)
                {
                    dWidth = Math.round(sWidth / fact * heightModalBody / dHeight);
                    dHeight = heightModalBody;

                    if (dWidth > widthModalBody)
                    {
                        dHeight = Math.round(dHeight * widthModalBody / dWidth);
                        dWidth = widthModalBody;
                    }
                }

                let canvas = document.createElement('canvas');
                canvas.width = dWidth;
                canvas.height = dHeight;

                if (widthModalBody === - 40 || (canvas.width === 300 && canvas.height === 150))
                {
                    const files = document.querySelector('#files').files;

                    editFile(files[0], 0);

                    return;
                }

                canvas.getContext('2d').drawImage(image, sx, sy, sWidth, sHeight, 0, 0, dWidth, dHeight);

                let fileRatio = dWidth / dHeight;

                let dataURL = '';

                let compression = (fullresolution === 1) ? <?php echo COMPRESSION_LEVEL_UPLOAD / 100 ?>  : <?php echo COMPRESSION_LEVEL_VIEW / 100?>;

                dataURL = canvas.toDataURL("image/<?php echo COMPRESSION_TYPE ?>", compression);

                if (fullresolution == 0)
                {
                    document.getElementById('result').innerHTML = '<img class="mx-auto d-block" src="' + dataURL + '"/>';
                }

                if (fullresolution == 1)
                {
                    document.getElementById('fileToUpload').value = dataURL.substring(23);

                    document.getElementById('fileRatio').value = fileRatio.toFixed(5);

                    const form = document.getElementById('uploadData');

                    const upload = new FormData(form);

                    for (const [key, value] of upload) {
                        console.log(`${key}: ${value}`);
                    }

                    submit().then(r => window.location.reload());

                    async function submit() {
                        await fetch('/upload', {
                            method: 'POST',
                            body: upload,
                        });
                    }
                }

/*                if (fullresolution == 1)
                {
                    canvas.toBlob((blob) => {
                        const reader = new FileReader();

                        reader.onload = () => {
                            console.log(reader.result);
                        }

                        data = reader.readAsBinaryString(blob);
                    }, "image/<?php /*echo COMPRESSION_TYPE */?>", compression);

                    console.log(data);

                    document.getElementById('fileRatio').value = fileRatio.toFixed(5);

                    const form = document.getElementById('uploadData');

                    const upload = new FormData(form);

                    upload.append('fileToUpload', data);

                    for (const [key, value] of upload) {
                        console.log(`${key}: ${value}`);
                    }

                    //submit().then(r => window.location.reload());

                    async function submit() {
                        await fetch('/upload', {
                            method: 'POST',
                            body: upload,
                        });
                    }
                }
*/            }

            image.src = readerEvent.target.result;
        }

        reader.readAsDataURL(file);

        //if (fullresolution == 1)
    }
}

function renderFileOnceMore(a, b, c, d)
{
    const files = document.querySelector('#files').files;

    editFile(files[0], 0, a, b, c, d);
}

function init()
{
    document.getElementById('slider-1').addEventListener('mouseup', slideOne);
    document.getElementById('slider-2').addEventListener('mouseup', slideTwo);
    document.getElementById('slider-3').addEventListener('mouseup', slideThree);
    document.getElementById('slider-4').addEventListener('mouseup', slideFour);
    document.getElementById('slider-1').addEventListener('touchend', slideOne);
    document.getElementById('slider-2').addEventListener('touchend', slideTwo);
    document.getElementById('slider-3').addEventListener('touchend', slideThree);
    document.getElementById('slider-4').addEventListener('touchend', slideFour);
    document.getElementById('button').addEventListener('click', uploadPicture);
}

function uploadPicture()
{
    const files = document.querySelector('#files').files;

    editFile(files[0], 1, document.getElementById('sliderOneValue').value, document.getElementById('sliderThreeValue').value, document.getElementById('sliderTwoValue').value, document.getElementById('sliderFourValue').value);
    //editFile(files[0], 1);
}

let sliderOne = document.getElementById("slider-1");
let sliderTwo = document.getElementById("slider-2");
let sliderThree = document.getElementById("slider-3");
let sliderFour = document.getElementById("slider-4");
let displayValOne = document.getElementById("range1");
let displayValTwo = document.getElementById("range2");
let displayValThree = document.getElementById("range3");
let displayValFour = document.getElementById("range4");
let minGap = 0;
let sliderTrack = document.querySelector(".slider-track");
let sliderMaxValue1 = document.getElementById("slider-1").max;
let sliderMaxValue2 = document.getElementById("slider-3").max;

function slideOne()
{
    if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap)
    {
        sliderOne.value = parseInt(sliderTwo.value) - minGap;
    }

    displayValOne.textContent = sliderOne.value;

    fillColor();
}

function slideTwo()
{
    if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap)
    {
        sliderTwo.value = parseInt(sliderOne.value) + minGap;
    }

    displayValTwo.textContent = sliderTwo.value;

    fillColor();
}

function slideThree()
{
    if (parseInt(sliderFour.value) - parseInt(sliderThree.value) <= minGap)
    {
        sliderThree.value = parseInt(sliderFour.value) - minGap;
    }

    displayValThree.textContent = sliderThree.value;

    fillColor();
}

function slideFour()
{
    if (parseInt(sliderFour.value) - parseInt(sliderThree.value) <= minGap)
    {
        sliderFour.value = parseInt(sliderThree.value) + minGap;
    }

    displayValFour.textContent = sliderFour.value;

    fillColor();
}

function fillColor()
{
    percent1 = (sliderOne.value / sliderMaxValue1) * 100;
    percent2 = (sliderTwo.value / sliderMaxValue1) * 100;
    percent1 = (sliderThree.value / sliderMaxValue2) * 100;
    percent2 = (sliderFour.value / sliderMaxValue2) * 100;
    sliderTrack.style.background = `linear-gradient(to right, #dadae5 ${percent1}% , #3264fe ${percent1}% , #3264fe ${percent2}%, #dadae5 ${percent2}%)`;

    document.getElementById('sliderOneValue').value = sliderOne.value;
    document.getElementById('sliderTwoValue').value = sliderTwo.value;
    document.getElementById('sliderThreeValue').value = sliderThree.value;
    document.getElementById('sliderFourValue').value = sliderFour.value;
    renderFileOnceMore(sliderOne.value, sliderThree.value, sliderTwo.value, sliderFour.value);
}

init();
<?php } else if ($case === '') { ?>
function init()
{
    alert('Hallo Welt');
}

init();
<?php } ?>