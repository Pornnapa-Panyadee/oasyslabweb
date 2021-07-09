<template>
    <Layout>
        <div class="wrapper">
            <div
                class="member"
                v-if="member"
            >
                <div class="title bg-main4 color-main6">
                    <span class="color-main4">{{displayMember.name}}</span>
                </div>
                <div class="picture imgWrapper">
                    <img
                        :src="'/' + displayMember.images.path"
                        :alt="displayMember.images.name"
                    >
                    <div class="overlay filter" />
                </div>
                <div class="contentWrapper">
                    <div class="space"></div>
                    <div class="content">
                        <div class="contentTitle">
                            <div>{{ $t('member.information') }}</div>
                        </div>
                        <div class="information">
                            <div>
                                <div class="informationLabel">
                                    {{ $t('member.email') }}
                                </div>
                                <div>{{ displayMember.email || $t('universal.null') }}</div>
                            </div>
                            <div>
                                <div class="informationLabel">
                                    {{ $t('member.website') }}
                                </div>
                                <div>{{ displayMember.website || $t('universal.null') }}</div>
                            </div>
                            <div>
                                <div class="informationLabel">
                                    {{ $t('member.level') }}
                                </div>
                                <div>{{ displayMember.levels.name }}</div>
                            </div>
                            <div>
                                <div class="informationLabel">
                                    {{ $t('member.position') }}
                                </div>
                                <div>{{ displayMember.positions.name }}</div>
                            </div>
                            <div class="twoColumns">
                                <div class="informationLabel">
                                    {{ $t('member.description') }}
                                </div>
                                <div v-html="displayMember.description" />
                            </div>
                            <div class="twoColumns">
                                <div class="informationLabel">
                                    {{ $t('member.field') }}
                                </div>
                                <div class="fields">
                                    <a
                                        class="field"
                                        v-for="(field, index) in displayMember.fields_interest"
                                        :key="index"
                                        :href="`/field/${field.slug}`"
                                    >
                                        {{ field.name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="contentTitle">
                            <div>{{ $t('member.publications') }}</div>
                        </div>
                        <div class="publicationsWrapper">
                            <div
                                class="publications"
                                v-for="(publicationType, index) in Object.keys(displayPublications).map(key => displayPublications[key])"
                                :key="index"
                            >
                                <div class="type">
                                    <div>{{ publicationType.name }}</div>
                                </div>
                                <div class="list">
                                    <div
                                        class="publication"
                                        v-for="(eachPublication, index) in publicationType.list"
                                        :key="index"
                                    >
                                        <p v-html="eachPublication.publications.detail" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            member: null
        }
    },
    computed: {
        displayMember() {
            const member = this.member
            if (member) {
                return {
                    ...member,
                    name: this._i18n.locale === 'th' ? member.th_name : member.en_name,
                    description: this._i18n.locale === 'th' ? member.th_description : member.en_description,
                    positions: {
                        ...member.positions,
                        name: this._i18n.locale === 'th' ? member.positions.name_th : member.positions.name_en,
                    },
                    levels: {
                        ...member.levels,
                        name: this._i18n.locale === 'th' ? member.levels.name_th : member.levels.name_en,
                    }
                }
            }
            return null
        },
        displayPublications() {
            const member = this.member
            if (member) {
                return member.publications.reduce((obj, publication) => {
                    if (!obj[publication.type.id]) {
                        obj[publication.type.id] = {
                            name: this._i18n.locale === 'th' ? publication.type.th_name : publication.type.en_name,
                            list: []
                        }
                    }
                    const publications = obj[publication.type.id].list
                    publications.push(publication)
                    return obj
                }, {})
            }
            return []
        }
    },
    mounted() {
        const urls = window.location.href.split('/')
        const slug = urls[urls.length - 1]
        axios.get('/api/member/' + slug)
            .then(response => response.data)
            .then(({ data }) => {
                this.member = data
            })
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
$pictureSize: 200px;
$nameTop: 36px;
.wrapper {
    padding-top: 32px;
    padding-bottom: 48px;
    @include container();
    & > .member {
        position: relative;
        margin-top: ($pictureSize / 2) + $nameTop;
        box-shadow: 0px 0px 40px #AAA;
        z-index: 0;
        padding-bottom: 32px;
        & > .title {
            position: absolute;
            top: -$nameTop;
            margin-left: ($pictureSize / 2);
            margin-right: 20%;
            padding: 12px 0;
            padding-left: ($pictureSize / 2) + 24px;
            font-weight: 900;
            font-size: 2em;
            border-bottom-left-radius: 4px;
            height: 100%;
            position: relative;
            & {
                @include respond-to($mobile) {
                    margin-left: 0;
                    font-size: 1.5em;
                    padding: 12px 16px;
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
                right: -6%;
                bottom: -24px;
                box-sizing: content-box;
                @include respond-to($mobile) {
                    right: initial;
                    left: 0;
                }
            }
        }
        & > .picture {
            position: absolute;
            top: -($pictureSize / 4) + -$nameTop;
            left: -($pictureSize / 6);
            & {
                @include respond-to($mobile) {
                    position: relative;
                    top: 0;
                    left: 0;
                    text-align: center;
                }
            }
            & > img {
                box-shadow: 0px 0px 10px #333;
                width: $pictureSize;
                height: $pictureSize;
                object-fit: cover;
                border-radius: 50%;
                & {
                    @include respond-to($mobile) {
                        box-shadow: none;
                    }
                }
            }
            & > .overlay {
                width: $pictureSize;
                height: $pictureSize;
                border-radius: 50%;
                left: 50%;
                margin-left: -($pictureSize / 2);
            }
        }
        & > .contentWrapper {
            margin-top: 12px;
            display: flex;
            flex-direction: row;
            & > .space {
                width: $pictureSize;
                & {
                    @include respond-to($mobile) {
                        display: none;
                    }
                }
            }
            & > .content {
                flex: 1;
                & {
                    @include respond-to($mobile) {
                        padding: 8px;
                    }
                }
                & > .contentTitle {
                    display: flex;
                    flex-direction: row;
                    justify-content: flex-start;
                    & > div {
                        font-weight: 500;
                        margin: 0 24px;
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
                & > .information {
                    padding: 24px;
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    grid-row-gap: 12px;
                    grid-column-gap: 12px;
                    font-size: 1.1em;
                    & > .twoColumns {
                        grid-column: 1 / span 2;
                    }
                    & {
                        @include respond-to($mobile) {
                            grid-template-columns: initial;
                            & > .twoColumns {
                                grid-column: initial;
                            }
                        }
                    }
                    & .informationLabel {
                        color: #999;
                        font-weight: 700;
                        font-size: 0.9em;
                    }
                    & .fields {
                        display: flex;
                        flex-direction: row;
                        flex-wrap: wrap;
                        & > .field {
                            background-color: #999;
                            border-radius: 12px;
                            padding: 4px 12px;
                            margin-right: 4px;
                            margin-bottom: 4px;
                            color: #FFF;
                            cursor: pointer;
                            transition: 0.5s;
                            &:hover {
                                background-color: #333;
                            }
                        }
                    }
                }
                & > .publicationsWrapper {
                    padding: 24px;
                    & > .publications {
                        & > .type {
                            display: flex;
                            flex-direction: row;
                            justify-content: flex-start;
                            & > div {
                                font-weight: 500;
                                margin: 0 24px;
                                font-size: 1.2em;
                                color: #FFF;
                                padding: 4px 48px;
                                border-radius: 24px;
                                background-color: #AAA;
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
                            & > .publication {
                                background-color: #FFF;
                                position: relative;
                                box-shadow: 0px 0px 10px #CCC;
                                border-radius: 8px;
                                padding: 32px;
                                padding-bottom: 24px;
                                margin: 24px 0;
                            }
                        }
                    }
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
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 50;
    border-radius: 50%;
}
</style>
