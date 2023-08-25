<template>
    <div class="ruzzifer-toolbar">
        <button type="button" class="ruzzifer-button" title="orqaga" command='undo'><i class='fa fa-undo'></i></button>
        <button type="button" class="ruzzifer-button" title="oldinga" command='redo'><i class='fa fa-redo'></i></button>
        <div class="ruzzifer-fore-wrapper" title="Yozuv rangi">
            <button type="button" class="ruzzifer-button">
                <i class='fa fa-font' style='color:#C96;'></i>
            </button>
            <div class="ruzzifer-fore-palette"></div>
        </div>
        <div class="ruzzifer-back-wrapper" title="Yozuv orqa foni">
            <button type="button" class="ruzzifer-button">
                <i class="fa fa-font ruzzifer-background"></i>
            </button>
            <div class="ruzzifer-back-palette"></div>
        </div>

        <button type="button" title="Qalin" class="ruzzifer-button" command='bold'>
            <i class='fa fa-bold'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='italic'>
            <i class='fa fa-italic'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='underline'>
            <i class='fa fa-underline'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='strikeThrough'>
            <i class='fa fa-strikethrough'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='justifyLeft'>
            <i class='fa fa-align-left'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='justifyCenter'>
            <i class='fa fa-align-center'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='justifyRight'>
            <i class='fa fa-align-right'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='justifyFull'>
            <i class='fa fa-align-justify'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='indent'>
            <i class='fa fa-indent'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='outdent'>
            <i class='fa fa-outdent'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='insertUnorderedList'>
            <i class='fa fa-list-ul'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='insertOrderedList'>
            <i class='fa fa-list-ol'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='createlink'>
            <i class='fa fa-link'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='unlink'>
            <i class='fa fa-unlink'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='subscript'>
            <i class='fa fa-subscript'></i>
        </button>
        <button type="button" class="ruzzifer-button" command='superscript'>
            <i class='fa fa-superscript'></i>
        </button>
        <button @click="emit('pageCreate')" type="button" class="ruzzifer-button">
            <i class="fa-light fa-plus"></i>
        </button>
        <select v-model="selectFont" @input="fontFamily" class="border-b py-0.5 outline-none text-gray-600 mx-4">
            <option value="Arial">Arial</option>
            <option value="Courier New">Courier New</option>
            <option value="Georgia">Georgia</option>
            <option value="Impact">Impact</option>
            <option value="Lucida Console">Lucida Console</option>
            <option value="Tahoma">Tahoma</option>
            <option value="Times New Roman">Times New Roman</option>
            <option value="Monospace">Monospace</option>
            <option value="Sans-Serif">Sans Serif</option>
            <option value="Verdana">Verdana</option>
        </select>
        <select v-model="selectSize" @change="fontSize" class="border-b py-0.5 outline-none text-gray-600">
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
        </select>
        <button type="button" @click="positionQrCode" class="ruzzifer-button">
            <i class="fa-solid fa-qrcode"></i>
        </button>
    </div>
</template>

<script setup lang="ts">
import { ref , onMounted } from 'vue'
const { editable, QrCodeIsset } = defineProps(['editable', 'QrCodeIsset'])
const QRCode = require('qrcode')


const emit = defineEmits(['pageCreate'])
const selectFont = ref('Times New Roman')
const selectSize = ref('14')

function fontSize(){
    const span:any = document.createElement('span')
    span.style.fontSize = selectSize.value + 'pt'
    span.innerHTML = document.getSelection()
    document.execCommand('insertHTML', false, span.outerHTML);
}


function fontFamily() {
    document.execCommand("fontName", false, selectFont.value);
    //@ts-ignore
    window.getSelection().empty();
}



function positionQrCode(){
    const img = document.createElement('img')
    img.src = '/images/qrcode.png'
    img.id = 'qrcode'
    img.classList.add('qrcode')

    const span = document.createElement('i')
    span.classList.add('span-qr')
    span.innerHTML = 'aaa' + img.outerHTML

    document.execCommand('insertHTML', false, span.outerHTML);
}



onMounted(() => {
    const buttons = document.querySelectorAll('.ruzzifer-toolbar button')

    for (let i = 0; i < buttons.length; i++) {
        const button = buttons[i] as HTMLButtonElement
        button.addEventListener('click', function () {
            const command = this.getAttribute('command') as string
            if (command == 'h1' || command == 'h2' || command == 'p') {
                document.execCommand('formatBlock', false, command)
            }
            if (command == 'forecolor' || command == 'backcolor') {
                const color = this.getAttribute('color') as string | undefined
                document.execCommand(command, false, color)
            }
            if (command == 'createlink' || command == 'insertimage') {
                const url: any = prompt('Enter the link here: ', 'http:\/\/')
                document.execCommand(command, false, url)
            }
            else document.execCommand(command, false, undefined)
        })
    }


    const colorPalette = ['#000000', '#FF9966', '#6699FF', '#99FF66', '#CC0000', '#00CC00', '#0000CC', '#333333', '#0066FF', '#FFFFFF']
    const forePalette = document.querySelector('.ruzzifer-fore-palette') as HTMLDivElement
    const backPalette = document.querySelector('.ruzzifer-back-palette') as HTMLDivElement
    if (editable) {
        for (var i = 0; i < colorPalette.length; i++) {
            forePalette.append(createButton('forecolor'))
            backPalette.append(createButton('backcolor'))
        }
    }

    function createButton(attribute) {
        const element = document.createElement('button')
        element.setAttribute('command', attribute)
        element.setAttribute('type', 'button')
        element.setAttribute('color', colorPalette[i])
        element.style.backgroundColor = colorPalette[i]
        element.classList.add('ruzzifer-palette-item')
        return element
    }
})
</script>