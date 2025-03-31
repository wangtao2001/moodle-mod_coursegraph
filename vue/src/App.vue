<template>
    <div>
        <div id="graph"></div>
    </div>
</template>

<script setup>
import * as echarts from 'echarts'
import axios from 'axios'
import { onMounted } from 'vue'

onMounted(async () => {
    const nodePageSize = 200
    const linkPageSize = 100
    const nodePageParallel = 5
    const linkPageParallel = 5
    const nodes = []
    const links = []

    const graph = echarts.init(document.getElementById('graph'))
    graph.showLoading({
        text: '加载中'
    })
    const categories = (await axios.post('/categories')).data

    const options = {
        legend: {
            data: categories.map(item => item.name)
        },
        series: [{
            type: 'graph',
            layout: 'force',
            roam: true,
            label: {
                show: true,
                formatter: '{b}',
                position: 'right'
            },
            lineStyle: {
                color: 'target',
                curveness: 0.3
            },
            categories,
            nodes,
            links
        }]
    }
    graph.setOption(options)

    async function getNodes() {
        let pageIndex = 0
        let continueFetch = true
        const parallelFetch = async (startPage) => {
            const promises = []
            for (let i = 0; i < nodePageParallel; i++) {
                promises.push(axios.post('/nodes', {
                    'page_size': nodePageSize,
                    'page_index': startPage + i
                }))
            }
            const results = (await Promise.all(promises)).flatMap(result => result.data)
            if (results.length != nodePageSize * nodePageParallel) {
                continueFetch = false
            }
            nodes.push(...results)
            graph.setOption({
                series: [{
                    nodes
                }]
            })
        }
        while (continueFetch) {
            await parallelFetch(pageIndex)
            pageIndex += nodePageParallel
        }
    }

    async function getLinks() {
        let pageIndex = 0
        let continueFetch = true
        const parallelFetch = async (startPage) => {
            const promises = []
            for (let i = 0; i < linkPageParallel; i++) {
                promises.push(axios.post('/relations', {
                    'page_size': linkPageSize,
                    'page_index': startPage + i
                }))
            }
            const results = (await Promise.all(promises)).flatMap(result => result.data)
            if (results.length != linkPageSize * linkPageParallel) {
                continueFetch = false
            }
            links.push(...results)
            graph.setOption({
                series: [{
                    links
                }]
            })
        }
        while (continueFetch) {
            await parallelFetch(pageIndex)
            pageIndex += linkPageParallel
        }
    }

    await Promise.all([
        getNodes(),
        getLinks()
    ])

    graph.hideLoading()
})
</script>

<style scoped>
#graph {
    width: 100%;
    height: 600px;
}
</style>
