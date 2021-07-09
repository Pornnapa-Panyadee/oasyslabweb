<template>
    <section
        id="about"
        class="wrapper"
    >
        <div class="lineBlue bg-main1"></div>
        <div class="content">
            <div class="description">
                <header>
                    <span class="bg-main4 color-main4">OASYS</span>
                </header>
                <article>
                    <div>
                        <strong>O</strong>ptimization theory and <strong>A</strong>pplications for *-<strong>SYS</strong>tems
                    </div>
                    <span v-html="displayData.aboutus && displayData.aboutus.description" />
                </article>
            </div>
            <div class="summarize">
                <div
                    class="item"
                    v-for="(stat, index) in displayData.stats"
                    :key="index"
                >
                    <img :src="`/images/icons/${stat.image}`" alt="">
                    <div class="label">{{ stat.name }}</div>
                    <div class="amount">{{ stat.amount }}</div>
                    <div class="amountBackground">{{ stat.amount }}</div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            data: {
                aboutus: null,
                stats: []
            }
        }
    },
    computed: {
        displayData() {
            return Object.keys(this.data).reduce((obj, dataKey) => {
                if (this.data[dataKey]) {
                    obj[dataKey] = this.data[dataKey]
                    obj[dataKey].description = this._i18n.locale === 'th' ? this.data[dataKey].th_description : this.data[dataKey].en_description
                }
                if (dataKey === 'stats') {
                    obj[dataKey] = this.data[dataKey].map(stat => {
                        return {
                            ...stat,
                            name: this._i18n.locale === 'th' ? stat.th_name : stat.en_name
                        }
                    })
                }
                return obj
            }, {})
        }
    },
    mounted() {
        axios.get('/api/aboutus')
            .then(response => response.data)
            .then(responseBody => {
                responseBody.data.forEach(data => {
                    data.keyword = data.keyword.replace('-', '')
                    if (data.keyword.includes('stat')) {
                        switch (data.keyword) {
                            case 'statProjects' :
                                data.image = 'project.png'
                                break
                            case 'statDevices' :
                                data.image = 'device.png'
                                break
                            case 'statAreas' :
                                data.image = 'area.png'
                                break
                            case 'statMembers' :
                                data.image = 'member.png'
                                break
                        }
                        this.data.stats.push(data)
                    }
                    else {
                        this.data[data.keyword] = data
                    }
                })
            })
    }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/mixins.scss';
@import '../../../sass/responsive.scss';

.wrapper {
    position: relative;
    margin-bottom: 48px;
    & > .lineBlue {
        position: absolute;
        top: 36px;
        left: 0;
        right: 0;
        height: 80px;
        z-index: -100;
    }
    & > .content {
        @include container();
        display: flex;
        flex-direction: row;
        align-items: center;
        & {
            @include respond-to($mobile) {
                flex-direction: column;
            }
        }
        & > .description {
            margin-right: 48px;
            flex: 3;
            position: relative;
            & {
                @include respond-to($mobile) {
                    margin-right: 0px;
                }
            }
            & > header {
                position: relative;
                & > span {
                    font-size: 4em;
                    padding: 12px 48px;
                    border-radius: 4px;
                    font-weight: 800;
                    position: absolute;
                    z-index: 1;
                    left: 50%;
                    transform: translateX(-50%);
                }
            }
            & > article {
                margin-top: 80px;
                background-color: #FFF;
                padding: 64px 48px;
                border-radius: 4px;
                box-shadow: 0 0 10px #AAA;
                min-height: 440px;
                span{
                    font-size:1rem;
                    line-height: 1.75rem;
                    @include respond-to($mobile) {
                        font-size:.9rem;
                        line-height: 1.6rem;
                    }
                }
                & {
                    @include respond-to($mobile) {
                        min-height: auto;
                        padding: 60px 30px 25px 30px;
                    }
                }
                & > div {
                    text-align: center;
                    font-size: 1.5em;
                    margin-bottom: 24px;
                }
            }
        }
        & > .summarize {
            width: 100%;
            flex: 2;
            margin-top: 10%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            & {
                @include respond-to($mobile) {
                    margin-top: 12%;
                }
            }
            & > .item {
                margin: 5% 0;
                position: relative;
                text-align: center;
                & > img {
                    width: 64px;
                    height: 64px;
                    border-radius: 50%;
                    margin-bottom: 12px;
                }
                & > .label {
                    text-align: center;
                    text-transform: uppercase;
                    font-weight: 500;
                    font-size: 1.3em;
                }
                & > .amount {
                    text-align: center;
                    line-height: 1em;
                    font-size: 2.5em;
                    font-weight: 900;
                }
                & > .amountBackground {
                    position: absolute;
                    z-index: -1;
                    font-size: 10em;
                    font-weight: 900;
                    top: -54px;
                    margin-left: auto;
                    margin-right: auto;
                    left: 0;
                    right: 0;
                    opacity: 0.1;
                }
            }
        }
    }
}
</style>

