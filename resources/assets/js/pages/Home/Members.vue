<template>
    <section
        id="members"
        class="wrapper"
    >
        <div class="lineBlue bg-main1"></div>
        <div class="content">
            <header>
                <span class="bg-main4 color-main4">{{ $t('team.header') }}</span>
            </header>
            <div class="list">
                <carousel
                    :nav="false"
                    :dots="false"
                    :responsive="silderResponsive"
                    v-if="members.length > 0"
                >
                    <div
                        class="member"
                        v-for="(member, index) in displayMembers"
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
                        <div class="position bg-main2 color-main2">
                            {{ member.positions.name }}
                        </div>
                    </div>

                    <template slot="prev">
                        <div class="leftButton">
                            <img src="/images/icons/arrow-left.png" alt="Previous">
                        </div>
                    </template>
                    <template slot="next">
                        <div class="rightButton">
                            <img src="/images/icons/arrow-right.png" alt="Next">
                        </div>
                    </template>
                </carousel>
                <div class="w-100 text-center pt-4">
                    <a href="/members" class="btn px-5 bg-main3 text-white">{{ displayButton }}</a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import carousel from '../../components/v-owl-carosuel'
import axios from 'axios'
export default {
    components: {
        carousel
    },
    data() {
        return {
            members: []
        }
    },
    mounted() {
        axios.get('/api/members')
            .then(response => response.data)
            .then(responseBody => {
                const members = responseBody.data.sort((memberA, memberB) => memberA.positions.priority - memberB.positions.priority)
                this.members = members
            })
    },
    computed: {
        silderResponsive() {
            return [...Array(24)].reduce((sum, each, index) => {
                let value = 0
                if (index !== 0) {
                    value = (index - 1) * 250 + 650
                }
                sum[value] = { items: index + 1 }
                return sum
            }, {})
        },
        displayMembers() {
            return this.members.map(member => {
                return {
                    ...member,
                    name: this._i18n.locale === 'th' ? member.th_name : member.en_name,
                    positions: {
                        ...member.positions,
                        name: this._i18n.locale === 'th' ? member.positions.name_th : member.positions.name_en,
                    }
                }
            })
        },
        displayButton(){
            if(this._i18n.locale === 'th'){
                return 'ดูทั้งหมด'
            }else{
                return 'Show All'
            }

        }
    },
    methods: {
        goToMemberPage(member) {
            window.open(`/member/${member.slug}`)
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/responsive.scss';
.wrapper {
    position: relative;
    padding: 64px 0;
    background-color: #DFDFDF;
    & > .lineBlue {
        position: absolute;
        top: 96px;
        left: 0;
        right: 0;
        height: 112px;
    }
    & > .content {
        position: relative;
        & > header {
            z-index: 1;
            text-align: center;
            & > span {
                font-weight: 500;
                font-size: 3em;
                padding: 16px 64px;
                border-radius: 4px;
                box-shadow: 0 0 12px rgba($color: #333, $alpha: 0.3);
            }
        }
        & > .list {
            background-color: #FFF;
            padding: 24px 64px;
            margin: 24px;
            border-radius: 4px;
            box-shadow: 0 0 24px rgba($color: #333, $alpha: 0.3);
            position: relative;
            .member {
                display: flex;
                flex-direction: column;
                margin: 12px 24px;
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
                & > .position {
                    text-align: center;
                    padding: 4px 0;
                    border-bottom-left-radius: 4px;
                    border-bottom-right-radius: 4px;
                }
            }
            %navigateButton {
                position: absolute;
                bottom: 0;
                opacity: 0.8;
                cursor: pointer;
                transition: 0.3s;
                &:hover {
                    opacity: 1;
                }
                & > img {
                    width: 36px;
                    height: 36px;
                }
            }
            & .leftButton {
                @extend %navigateButton;
                left: 24px;
                top: 50%;
                margin-top: -13px;
            }
            & .rightButton {
                @extend %navigateButton;
                right: 24px;
                top: 50%;
                margin-top: -13px;
            }
        }
    }
}
.imgWrapper {
    position: relative;
}

.overlay {
    position: absolute;
    top: 0;
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
}
</style>
