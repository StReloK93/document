import moment from 'moment'

export default [
    { field: "id", headerName: 'Kod', width: 60 },
    { field: "name", headerName: 'Qisqacha mazmuni', flex: 1 },
    { field: "reject_type.name", headerName: 'Hujjat turi' },
    { field: "organization.shortname", headerName: "Bo'linma" },
    { field: "user.name", headerName: 'Yaratdi' },
    { 
        field: "positions", headerName: 'Tasdiqlanganligi',
        cellRenderer: (cell) => {
            var text = ''
            const yes = '<i class="fal fa-check text-teal-600 px-1 w-6"></i>'
            const no = '<i class="fal fa-times text-red-600 px-1 w-6"></i>'
            cell.value.forEach((subs) => {
                if (subs.check) text += yes
                else text += no
            })

            return text
        }
    },
    { field: "created_at", headerName: 'Yaratilgan vaqt' , cellRenderer: (cell) => moment(cell.value).format('DD.MM.YYYY HH:mm')},
]