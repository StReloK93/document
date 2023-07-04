<template>
    <main class="ruzzifer-editor">
        <div v-if="editable" class="ruzzifer-toolbar">
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
            <!-- <button type="button" class="ruzzifer-button" command='insertimage'>
                <i class='fa fa-image'></i>
            </button> -->
            <button type="button" class="ruzzifer-button" command='subscript'>
                <i class='fa fa-subscript'></i>
            </button>
            <button type="button" class="ruzzifer-button" command='superscript'>
                <i class='fa fa-superscript'></i>
            </button>
            <button @click="PageCreate" type="button" class="ruzzifer-button">
                <i class="fa-light fa-plus"></i>
            </button>
            <button @click="PrintElem" type="button" class="ruzzifer-button">
                <i class="fa-regular fa-print"></i>
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
        </div>
        <main class="ruzzifer-pages" @click="closeAllModals">
            <aside class="ruzzifer-absolute">
                <section v-for="(page) in modelValue" class="ruzzifer-page-container relative">

                    <main v-if="page.opened" @click.stop class="ruzzifer-page-paddings noprint">
                        <header class="ruzzifer-header noprint">
                            <button type="button" @click.stop="page.opened = false" class="px-4 py-1.5 hover:text-red-500">
                                <i class="fa-light fa-xmark"></i>
                            </button>
                        </header>
                        <table>
                            <tr>
                                <td style="width: 40px"></td>
                                <td>
                                    <input @keydown.enter.prevent style="text-align: center;" type="text" v-model="page.settings.paddingTop">
                                </td>
                                <td style="width: 40px"></td>
                            </tr>
                            <tr>
                                <td style="width: 40px">
                                    <input @keydown.enter.prevent style="width: 40px;text-align: center;" type="text" v-model="page.settings.paddingLeft">
                                </td>
                                <td><div class="ruzzifer-mini-page"></div></td>
                                <td style="width: 40px">
                                    <input @keydown.enter.prevent style="width: 40px;text-align: center;" type="text" v-model="page.settings.paddingRight">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40px"></td>
                                <td>
                                    <input @keydown.enter.prevent style="text-align: center;" type="text" v-model="page.settings.paddingBottom">
                                </td>
                                <td style="width: 40px;"></td>
                            </tr>
                        </table>
                    </main>

                    <div v-if="editable" class="ruzzifer-page-params noprint">
                        <button @click.stop="page.menuOpened = true" type="button">
                            <i class="fa-regular fa-ellipsis-vertical"></i>
                        </button>
                        <main v-if="page.menuOpened" class="ruzzifer-page-menu text-gray-500">
                            <button @click.stop="page.opened = true" type="button">
                                <i class="fa-duotone fa-gear"></i> Sozlamalar
                            </button>
                            <button @click="PageDelete(page)" type="button">
                                <i class="fa-duotone fa-trash"></i> O'chirish
                            </button>
                        </main>
                    </div>
                    <div class="ruzzifer-page"
                        :style="{
                            paddingLeft: page.settings.paddingLeft + 'mm',
                            paddingRight: page.settings.paddingRight + 'mm',
                            paddingTop: page.settings.paddingTop + 'mm',
                            paddingBottom: page.settings.paddingBottom + 'mm',
                        }"
                        :contenteditable="editable"
                        @input="(event: any) => PageEdit(event, page)">
                    </div>
                    <PrintPoints v-if="editable == false"  :pattern="selected" :number="Math.random()" :clickable="selected.backup == null" class="absolute bottom-3 w-full px-4"></PrintPoints>
                </section>
            </aside>
        </main>
    </main>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import Swal from '../modules/swal'
import PrintPoints from './PrintPoints.vue'
const { modelValue, editable , selected } = defineProps(['modelValue', 'editable', 'selected'])

const selectFont = ref('Times New Roman')
const selectSize = ref('14')

const emit = defineEmits(['update:modelValue'])
const defaultSet = {
    html: '',
    settings: {
        paddingLeft: 15,
        paddingRight: 15,
        paddingTop: 15,
        paddingBottom: 15,
    },
    opened: false,
    menuOpened: false,
}

if(modelValue == null || modelValue.length == 0) modelValue[0] = structuredClone(defaultSet)


function PageCreate(){
    modelValue.push(structuredClone(defaultSet))
}


function PageDelete(page){
    const index = modelValue.findIndex((element) => element == page)
    
    Swal.fire({
        title: "Aniq o'chirmoqchimisiz ?",
        text: "Sahifa malumotlari o'chib ketadi!",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            modelValue.splice(index, 1);
        }
    })
    
}

function PageEdit(event, page) {
    modelValue.forEach(element => {
        if(element == page){
            element.html = event.target.innerHTML
        }
    })
    emit('update:modelValue', modelValue)
}


function closeAllModals(){
    modelValue.forEach(page => {
        page.opened = false
        page.menuOpened = false
    })
}


function PrintElem()
{
    const mywindow: any = window.open('', 'mywindow', 'status=1,width=800,height=600')
    const docu = document.querySelector('.ruzzifer-pages') as HTMLDivElement
    
    mywindow.document.write('<html><head><title>' + document.title  + '</title>')
    mywindow.document.write('<link rel="stylesheet" href="/css/app.css" type="text/css" /></head>')
    mywindow.document.write('<body onafterprint="self.close()">')
    mywindow.document.write(docu.innerHTML)
    mywindow.document.write('</body></html>')

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    setTimeout(() => {
        mywindow.print()
        mywindow.close()
    }, 100)

    return true;
}

function fontSize(){
    const span = document.createElement('span')
    span.style.fontSize = selectSize.value + 'pt'

    //@ts-ignore
    span.innerHTML =  document.getSelection()
    
    document.execCommand('insertHTML', false, span.outerHTML);
}


function fontFamily() {
        document.execCommand("fontName", false, selectFont.value); //replace monospace with selected font
        //@ts-ignore
        window.getSelection().empty(); // unselects the selected text
    }

defineExpose({ PrintElem })

onMounted(() => {
    const colorPalette = ['#000000', '#FF9966', '#6699FF', '#99FF66', '#CC0000', '#00CC00', '#0000CC', '#333333', '#0066FF', '#FFFFFF']
    const forePalette = document.querySelector('.ruzzifer-fore-palette') as HTMLDivElement
    const backPalette = document.querySelector('.ruzzifer-back-palette') as HTMLDivElement
    if (editable) {
        for (var i = 0; i < colorPalette.length; i++) {
            forePalette.append(createButton('forecolor'))
            backPalette.append(createButton('backcolor'))
        }
    }

    const ruzziferPages = document.querySelectorAll('.ruzzifer-page')

    ruzziferPages.forEach((element, index) => {
        element.innerHTML = modelValue[index].html
    })

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