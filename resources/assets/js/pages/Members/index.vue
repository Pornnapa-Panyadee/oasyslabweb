<template>
    <Layout>
        <section class="wrapper">
            <div class="title bg-main4 color-main6">
                <span class="color-main4">Members</span>
            </div>
            <div
                class="members"
                v-for="(position, index) in displayPositions"
                :key="index"
            >
                <div class="name">
                    <div>{{ position.name }}</div>
                </div>
                <div class="list">
                    <div
                        class="member"
                        v-for="(member, index) in displayMembersByPositions[position.id]"
                        :key="index"
                        @click="goToMemberPage(member)"
                    >
                        <div class="image imgWrapper">
                            <img
                                :src="member.images.path"
                                :alt="member.name"
                            >
                            <div class="overlay filter" />
                        </div>
                        <div class="name">
                            {{ member.name }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from '../Layout'
import axios from 'axios'
export default {
    components: {
        Layout
    },
    data() {
        return {
            membersByPositions: {},
            positions: []
        }
    },
    computed: {
        displayPositions() {
            return this.positions.map(position => {
                return {
                    ...position,
                    name: this._i18n.locale === 'th' ? position.name_th : position.name_en,
                }
            })
        },
        displayMembersByPositions() {
            return Object.keys(this.membersByPositions).reduce((sum, key) => {
                sum[key] = this.membersByPositions[key].map(member => {
                    return {
                        ...member,
                        name: this._i18n.locale === 'th' ? member.th_name : member.en_name,
                    }
                })
                return sum
            }, {})
        }
    },
    mounted() {
        axios.get('/api/members')
            .then(response => response.data)
            .then(responseBody => {
                this.positions = responseBody.data
                    .map(member => member.positions)
                    .reduce((sum, position) => {
                        if (!sum.find(eachPos => eachPos.id === position.id)) {
                            sum.push(position)
                        }
                        return sum
                    }, [])
                    .sort((positionA, positionB) => positionA.priority - positionB.priority)

                this.membersByPositions = responseBody.data.reduce((sum, member) => {
                    if (!sum[member.positions.id]) {
                        sum[member.positions.id] = []
                    }
                    sum[member.positions.id].push(member)
                    return sum
                }, {})
            })
    },
    methods: {
        goToMemberPage(member) {
            location.href = `/member/${member.slug}`
        }
    }
}
</script>

<style lang="scss">
body {
    background-color: #F0F0F0;
}
</style>


<style lang="scss" scoped>
@import '../../../sass/mixins.scss';
@import '../../../sass/responsive.scss';
.wrapper {
    padding: 64px 0;
    @include container();
    & > .title {
        padding: 12px 48px;
        font-weight: 900;
        font-size: 3em;
        border-bottom-left-radius: 4px;
        height: 100%;
        position: relative;
        & {
            @include respond-to($mobile) {
                margin-left: 10vw;
                font-size: 2em;
                padding: 12px 45px;
            }
        }
        &::after {
            content: '';
            display: block;
            position: absolute;
            width: 100%;
            padding-left: 36px;
            height: 64px;
            z-index: -1;
            background-color: currentColor;
            left: -36px;
            bottom: -36px;
            box-sizing: content-box;
        }
    }
    & > .members {
        margin-top: 56px;
        margin-bottom: 24px;
        & > .name {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            & > div {
                font-weight: 500;
                margin: 24px;
                font-size: 1.5em;
                color: #FFF;
                padding: 4px 48px;
                border-radius: 24px;
                background-color: #555;
                &::before {
                    content: '● ';
                }
                & {
                    @include respond-to($mobile) {
                        margin: 0;
                    }
                }
            }
        }
        & > .list {
            display: grid;
            grid-template-columns: auto auto auto;
            @include respond-to($mobile) {
                grid-template-columns: auto;
            }
            .member {
                display: flex;
                flex-direction: column;
                margin: 2% 4%;
                height: 100%;
                transition: 0.3s;
                border-radius: 4px;
                &:hover {
                    cursor: pointer;
                    box-shadow: 0 0 24px #AAA;
                }
                & {
                    @include respond-to($mobile) {
                        &:hover {
                            cursor: inherit;
                            box-shadow: none;
                        }
                    }
                }
                & > .image {
                    flex: 1;
                    margin: 24px;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    justify-content: center;
                    & > img {
                        min-width: 150px;
                        min-height: 150px;
                        max-width: 150px;
                        max-height: 150px;
                        border-radius: 50%;
                        object-fit: cover;
                    }
                }
                & > .name {
                    font-size: 1.3em;
                    font-weight: 500;
                    text-align: center;
                }
            }
        }
    }
}

.imgWrapper {
    position: relative;
}

.overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    right: 0;
    bottom: 0;
    z-index: 50;
    min-width: 150px;
    min-height: 150px;
    max-width: 150px;
    max-height: 150px;
    border-radius: 50%;
    margin-left: -75px;
    margin-top: -75px;
}
</style>
