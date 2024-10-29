<script setup>

    import { ref, onMounted, onUpdated } from "vue"
    

    const props = defineProps({
        events: {}
    })

    const year = ref(new Date().getFullYear())
    const month = ref(new Date().getMonth())
    const day = ref(new Date().getDate())
    const hour = ref('')
    const minutes = ref('')

    const date = ref('')
    const monthStr = ref('')
    const shortMonthStr = ref('')
    const evento = ref([])
    const openModalEvent = ref(false)

    const daysOfTheWeek = {
        1: 'Domingo',
        2: 'Lunes',
        3: 'Martes',
        4: 'Miercoles',
        5: 'Jueves',
        6: 'Viernes',
        7: 'Sabado',
    }

    const monthsOfTheYear = {
        1: 'Enero',
        2: 'Febrero',
        3: 'Marzo',
        4: 'Abril',
        5: 'Mayo',
        6: 'Junio',
        7: 'Julio',
        8: 'Agosto',
        9: 'Septiembre',
        10: 'Octubre',
        11: 'Noviembre',
        12: 'Diciembre'
    }

    const daysInCurrentMonth = ref(0)
    const firstDayOfCurrentMonth = ref(0)
    const lastEmptyCells = ref(0)

    const getDaysInMonth = () => {
        daysInCurrentMonth.value = new Date(
            year.value,
            month.value + 1, // 👈️ months are 0-based
            0
        ).getDate()
    }

    const getFirstDayOfMonth = () => {
        firstDayOfCurrentMonth.value = new Date(
            year.value,
            month.value,
            1
        ).getDay()
    }

    const lastCalendarCells = () => {
        let totalGrid = firstDayOfCurrentMonth.value <= 5 ? 35 : 42
        lastEmptyCells.value = totalGrid - daysInCurrentMonth.value - firstDayOfCurrentMonth.value
    }

    const isToday = (day) => {
        let today = new Date()
        if (
            year.value == today.getFullYear() &&
            month.value == today.getMonth() &&
            day == today.getDate()
        )
            return true

        return false
    }

    const isEventToday = (day, startdate) => {
        if (
            year.value == startdate.substring(0, 4) &&
            month.value + 1 == startdate.substring(5, 7) &&
            day == startdate.substring(8, 10)
        )
            return true

        return false
    }

    const maxThreeTodaysEvent = (day, events) => {
        if (!events.length) return []

        let threeTodaysEventArr = []

        events.forEach((event) => {
            if (threeTodaysEventArr.length == 3) return threeTodaysEventArr;

            if (isEventToday(day, event.time.start)) {
                threeTodaysEventArr.push(event)
            }
        })

        return threeTodaysEventArr;
    }

    const allTodaysEvent = (day, events) => {
        if (!events.length) return []

        let todaysEvent = []
        events.forEach((event) => {
            if (isEventToday(day, event.time.start)) {
                todaysEvent.push(event)
            }
        })

        return todaysEvent;
    }



    function incrementMonth() {
        if (month.value == 11) {
            year.value ++
            month.value = 0
        }else{
            month.value ++
        }

        date.value = new Date(
            year.value,
            month.value,
            day.value
        )
    }

    function decrementMonth() {
        if (month.value == 0) {
            year.value --
            month.value = 11
        }else{
            month.value --
        }

        date.value = new Date(
            year.value,
            month.value,
            day.value
        )
    }
    function incrementDay(val) {
        day.value = day.value + val
    }

    function setMonth(val) {
        month.value = val;
    }

    function setYear(val) {
        year.value = val
    }

    function resetDate() {
        year.value = new Date().getFullYear()
        month.value = new Date().getMonth()
        day.value = new Date().getDate()
    }

    const prepareMonths = () => {
        monthStr.value = monthsOfTheYear[month.value + 1]
        shortMonthStr.value = monthStr.value.substring(0, 3)
    }

    
    const initializeDatePicker = () => {
        date.value = new Date(
            year.value,
            month.value,
            day.value
        )
    }

    
    const handleDate = (modelData) => {
        date.value = modelData

        setMonth(date.value.getMonth())
        setYear(date.value.getFullYear())
    }

    function showEvent(event){
        openModalEvent.value = true
        evento.value = event
    }


    onMounted(() => {
        getDaysInMonth()
        getFirstDayOfMonth()
        lastCalendarCells()
        prepareMonths()
        initializeDatePicker()
    })

    onUpdated(() => {
        getFirstDayOfMonth()
        prepareMonths()
        lastCalendarCells()
    })


</script>

<template>

    <div class="col-span-7">
        
        <div class="w-full flex justify-between items-center">
            <div class="w-full flex justify-between items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-gray-800 cursor-pointer hover:h-6 hover:w-6 transition-all" @click="decrementMonth()">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                    </svg>
                </div>
            
                <div class="w-1/3 p-2 md:p-4">
                    <div class="w-full inline-flex space-x-1 text-sm md:text-xl lg:text-2xl text-left font-bold md:font-semibold">
                        <span class="md:hidden">{{ shortMonthStr }}</span>
                        <span class="hidden md:block">{{ monthStr }}</span>
                        <span>{{ year }}</span>
                    </div>
                    <span class="text-center hidden">{{ day + '-' + month + '-' + year }}</span>
                </div>
    
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-gray-800 cursor-pointer hover:h-6 hover:w-6 transition-all" @click="incrementMonth()">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
          <!-- Current month and year -->
          <!-- <div class="w-1/3 p-2 md:p-4">
            <div
              class="w-full inline-flex space-x-1 text-sm md:text-xl lg:text-2xl text-left font-bold md:font-semibold"
            >
              <span class="md:hidden">{{ shortMonthStr }}</span
              ><span class="hidden md:block">{{ monthStr }}</span
              ><span>{{ year }}</span>
            </div>
          </div> -->
          <!-- -------------------------- -->

          <!-- Naviigation -->
            <!-- <div class="hidden md:flex w-1/3 text-gray-600">
                <div class="flex space-x-3 items-center justify-between">
                    
                </div>
            </div> -->
          <!-- ----------------------------- -->

          <!-- Date picker and date view -->
          <div class="w-2/3 md:w-1/3 flex justify-end pr-2 md:pr-4">
            <div class="flex space-x-2 md:space-x-5">
              <datepicker
                v-model="date"
                auto-apply
                close-on-scroll
                @update:modelValue="handleDate"
              >
                <template #trigger>
                  <div
                    class="flex space-x-1 md:space-x-2 justify-around items-center border rounded-sm px-2 md:px-5 py-1 md:py-2 cursor-pointer hover:bg-gray-200 transition-colors"
                  >
                    <div>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"
                        />
                      </svg>
                    </div>
                    <div>
                      <h1 class="text-xs md:text-base font-medium md:font-semibold">
                        {{ shortMonthStr }}
                      </h1>
                    </div>
                  </div>
                </template>
              </Datepicker>

              <div
                class="flex justify-center items-center border rounded-sm px-2 md:px-5 py-1 md:py-2 cursor-pointer hover:bg-gray-200 transition-colors"
                @click="resetDate"
              >
                <h1 class="text-xs md:text-base font-medium md:font-semibold">
                  Hoy
                </h1>
              </div>
            </div>
          </div>
        </div>
    </div>
    <br>
    
    <div ref="calendarContainer" class="min-h-full min-w-full text-gray-800">
        <div class="w-full border grid grid-cols-7">

            <div v-for="day in daysOfTheWeek" class="text-center text-sm md:text-base lg:text-lg font-medium border">
                <span class="hidden md:block">
                    {{ day }}
                </span>
                <span class=" md:hidden">
                    {{ day.substring(0,3) }}
                </span>
            </div>

            <div v-if="firstDayOfCurrentMonth > 0" v-for="day in firstDayOfCurrentMonth" :key="day" class="h-16 md:h-36 w-full border opacity-50"></div>

            <div v-for="day in daysInCurrentMonth" :key="day" class="h-16 md:h-36 w-full border align-top">
                <div class="w-full h-full text-xs md:text-sm lg:text-base text-center transition-colors" :class="{
                    'bg-slate-200 text-gray-600 font-medium': isToday(day),
                    'hover:bg-gray-100 hover:text-gray-700': !isToday(day),
                }">
                    {{ day }}

                    <div v-if="maxThreeTodaysEvent(day, events).length" v-for="evt in maxThreeTodaysEvent(day, events)"
                        class="hidden md:block">
                        <div class="w-full px-2 py-1 flex space-x-1 items-center whitespace-nowrap overflow-hidden border-0 cursor-pointer rounded-sm "
                            @click="showEvent(evt)">
                            <div class="">
                                <div class="h-2 w-2 rounded-full bg-purple-600"></div>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-xs tracking-tight text-clip overflow-hidden hover:scale-125">
                                    {{ evt.title }}
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div v-if="allTodaysEvent(day, events).length > 3"
                        class="hidden md:flex mt-2 w-full px-2 py-1 space-x-2 items-center whitespace-nowrap overflow-hidden hover:text-gray-800 hover:font-medium cursor-pointer rounded-sm"
                        @click="openModal(day, allTodaysEvent(day, events))">
                        <div class="w-1/12">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                            </svg>
                        </div>
                        <div class="w-11/12">
                            <h6 class="text-xs tracking-tight text-clip text-left overflow-hidden">
                                {{ allTodaysEvent(day, events).length - 3 + " eventos mas" }}
                            </h6>
                        </div>
                    </div>

                    <div v-if="allTodaysEvent(day, events).length > 0"
                        class="flex md:hidden h-2/3 w-full justify-center items-center"
                        @click="openModal(day, allTodaysEvent(day, events))">
                        <div class="h-6 w-6 flex justify-center items-center text-xs bg-purple-600 rounded-full shadow-sm">
                            <h3 class="font-medium text-white">
                                {{ allTodaysEvent(day, events).length }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="lastEmptyCells > 0" v-for="day in lastEmptyCells" :key="day" class="h-16 md:h-36 w-full border opacity-50"></div>

            <!-- mobile navigation -->
            <!-- <div class="md:hidden col-span-7 flex justify-between items-center p-2">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 hover:text-gray-500 cursor-pointer hover:h-6 hover:w-6 transition-all"
                        @click="decrementMonth(1)">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                    </svg>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 hover:text-gray-500 cursor-pointer hover:h-6 hover:w-6 transition-all"
                        @click="incrementMonth(1)">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div> -->
        </div>
    </div>

    <!-- use the modal component -->
    <!-- <transition name="modal">
        <Modal v-if="modalShow" @close-modal="closeModal" @toggle-popover="togglePopover" :day="modalDay"
            :month="getMonth" :year="getYear" :events="modalEvents" />
    </transition> -->

    <!-- popover component  -->
    <!-- <div ref="popoverRef" :class="{ hidden: !popoverShow, block: popoverShow }"
        class="bg-gray-100 mb-3 block z-50 max-w-xs rounded-lg shadow-md">
        <slot name="eventDialog" :eventDialogData="todaysEvent" :closeEventDialog="togglePopover" />
    </div> -->

    <modal :open="openModalEvent">
        <template #header>
            {{ evento.title }}
        </template>
        <div>
            {{ evento.description }}
        </div>
        <template #footer>
            <btn @click="openModalEvent = false" text="cerrar" class="btn-dark shadow-neutral-900" />
        </template>
    </modal>
</template>