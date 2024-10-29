import { defineStore } from 'pinia'
import { ref } from 'vue'


export const useGlobalStore = defineStore('global', () => {

    // AÑOS
    //----------------------------------------
    const year = new Date()
    //----------------------------------------

    // INICIO SIDEBAR
    //----------------------------------------
    const showSide = ref(false)

    const toggleSide = () => {
        showSide.value = !showSide.value
    }
    //----------------------------------------
    // FIN SIDEBAR

    // INICIO TITLE PAGE
    //----------------------------------------

    const titlePage = ref({
        title : '',
        icon : 'fas fa-home',
        textColor : 'text-white',
        color : 'bg-blue-muni'
    })

    function changeTitlePage (title = 'Home',icon = 'fas fa-home',color = 'bg-blue-muni',textColor = 'text-white') {
        titlePage.value.title = title
        titlePage.value.icon = icon
        titlePage.value.textColor = textColor
        titlePage.value.color = color
    }   
    //----------------------------------------
    // FIN TITLE PAGE


    // INICIO ALERTA TOAST
    //----------------------------------------
    const toasts = ref([])

    function setAlert(message,type,title = ' A T E N C I Ó N '){
        toasts.value.push({ message : message, type : type, title : title })
    }
    //----------------------------------------
    // FIN ALERTA TOAST


    function getNestedValue(obj, key) {
        const keys = key.split('.');
        for (const innerKey of keys) {
            if (obj.hasOwnProperty(innerKey)) {
                obj = obj[innerKey];
            } else {
                return null;
            }
        }
        return obj;
    }

    function formatter (value, type) {

        let result
    
        switch (type) {
            case 'numeric':
                result = new Intl.NumberFormat("es-GT").format(value)
                break;
            case 'currency':
                result = new Intl.NumberFormat("es-GT", {
                    'style': "currency",
                    'currency': "GTQ",
                    'minimumFractionDigits': 2,
                }).format(value)
                break;
            case 'date':
                
                    const date = new Date(value)
                    const d = String(date.getDate()).padStart(2,'0')
                    const m = String(date.getMonth() + 1).padStart(2,'0')
                    const y = String(date.getFullYear())
        
                    result = value ? `${y}-${m}-${d}` : ''
    
                break;
            case 'datetime':
                
                const fecha = new Date(value)
    
                const dia = fecha.getfecha().padStart(2,'0')
                const mes = fecha.getMonth.padStart(2,'0')
                const anio = fecha.getFullYear()
                const h = fecha.getHours().padStart(2,'0')
                const mi = fecha.getMinutes().padStart(2,'0')
                const s = fecha.getSeconds().padStart(2,'0')
    
                result = `${anio}-${mes}-${dia} ${h}:${mi}:${s}`
    
                break;
            default:
                result = value
                break;
        }
        return result
    }



    return {
        showSide,
        toggleSide,

        titlePage,
        changeTitlePage,

        toasts,
        setAlert,

        year,

        getNestedValue,
        formatter,
    }
})