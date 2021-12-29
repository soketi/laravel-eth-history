<template>
    <Head title="Dashboard" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gas Price History
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl flex items-start mx-auto sm:px-6 lg:px-8 space-x-2">
                <div class="w-full">
                    <apexchart
                        type="area"
                        :options="chartOptions"
                        :series="chartSeries"
                    />
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script>
import DashboardLayout from '@/Layouts/Dashboard'
import { Head } from '@inertiajs/inertia-vue3';
import VueApexCharts from 'vue3-apexcharts'

export default {
    components: {
        apexchart: VueApexCharts,
        DashboardLayout,
        Head,
    },

    props: [
        'initialGasPriceHistory',
    ],

    data() {
        return {
            gasPriceHistory: [],
        };
    },

    created() {
        this.gasPriceHistory = this.initialGasPriceHistory;
    },

    unmounted() {
        window.Echo.leave('eth');
    },

    mounted() {
        window.Echo
            .channel('eth')
            .error((error) => {
                this.throwError(`Received error: ${JSON.stringify(error)}`);
            })
            .listen('.gas.price', ({ time, gasPrice }) => {
                this.gasPriceHistory.push({ wei: gasPrice, time });
            });
    },

    methods: {
        throwError(error) {
            console.error(error);
        },
    },

    computed: {
        chartOptions() {
            return {
                chart: {
                    id: 'gas-price'
                },
                xaxis: {
                    type: 'datetime',
                    categories: this.gasPriceHistory.map(({ time }) => time),
                },
                zoom: {
                    type: 'x',
                    enabled: true,
                    autoScaleYaxis: true
                },
                toolbar: {
                    autoSelected: 'zoom',
                },
            };
        },

        chartSeries() {
            return [{
                name: 'Gas Price (WEI)',
                data: this.gasPriceHistory.map(({ wei }) => wei),
            }];
        },
    },
}
</script>
