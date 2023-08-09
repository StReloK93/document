import moment from 'moment'

export default function column(positions){
    return [
        { field: "id", headerName: 'Kod', width: 60 },
        { field: "name", headerName: 'Qisqacha mazmuni', flex: 1 },
        { field: "reject_type.name", headerName: 'Hujjat turi' },
        { field: "organization.shortname", headerName: "Bo'linma" },
        { field: "user.name", headerName: 'Yaratdi' },
        { 
            field: "positions", headerName: 'Tasdiqlanganligi',
            cellClass: ['flex' , 'items-center'],
            cellRenderer: (cell) => {
                var text = ''
                
                const yesMy = `<i class="fa-duotone fa-check text-blue-600 px-1 w-6">
                                    <i class="fa-solid fa-circle-small absolute text-[7px] -top-[6px] left-[7px]"></i>
                                </i>`
                const yes = '<i class="fal fa-check text-teal-600 px-1 w-6"></i>'
                const noMy = `<i class="fa-solid fa-xmark text-blue-600 px-1 w-6 relative">
                                <i class="fa-solid fa-circle-small absolute text-[7px] -top-[7px] left-[6px]"></i>
                            </i>`
                const no = '<i class="fal fa-times text-red-600 px-1 w-6"></i>'
                
                cell.value.forEach((subs) => {
                    if(positions.includes(subs.position_id)){
                        if (subs.check) text += yesMy
                        else text += noMy
                    }
                    else{
                        if (subs.check) text += yes
                        else text += no
                    }
                })
    
                return text
            }
        },
        { field: "created_at", headerName: 'Yaratilgan vaqt' , cellRenderer: (cell) => moment(cell.value).format('DD.MM.YYYY HH:mm')},
    ]
}