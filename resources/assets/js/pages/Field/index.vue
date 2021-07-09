<template>
    <Layout>
        <div class="wrapper">
            <div class="list">
                <div class="title">{{ $t('field.list') }}</div>
                <ul>
                    <li
                        v-for="(field, index) in tags"
                        :key="index"
                        :class="{ 'active' : field.id === tagId }"
                        @click="goToField(field.slug)"
                    >
                        {{ field.name }}
                    </li>
                </ul>
            </div>
            <div
                class="members"
                v-if="selectedTag"
            >
                <div
                    class="member"
                    v-for="(member, index) in displayMembers"
                    :key="index"
                    @click="goToMember(member.slug)"
                >
                    <div class="picture imgWrapper">
                        <img
                            :src="'/' + member.images.path"
                            :alt="member.images.name"
                        >
                        <div class="overlay filter" />
                    </div>
                    <div class="information">
                        <div class="name">{{ member.name }}</div>
                        <div class="position">
                            <strong>{{ $t('field.position') }}</strong>: {{ member.levels.name }}
                        </div>
                        <div class="level">
                            <strong>{{ $t('field.level') }}</strong>: {{ member.positions.name }}
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
            tags: [],
            tagId: null,
            selectedTag: null
        }
    },
    computed: {
        style() {

        },
        displayMembers() {
            return this.selectedTag.members_interest.map(memberObj => {
                const member = memberObj.member
                return {
                    ...member,
                    name: this._i18n.locale === 'th' ? member.th_name : member.en_name,
                    positions: {
                        ...member.positions,
                        name: this._i18n.locale === 'th' ? member.positions.name_th : member.positions.name_en,
                    },
                    levels: {
                        ...member.levels,
                        name: this._i18n.locale === 'th' ? member.levels.name_th : member.levels.name_en,
                    }
                }
            })
        }
    },
    mounted() {
        const urls = window.location.href.split('/')
        const slug = urls[urls.length - 1]

        Promise.all([
            axios.get('/api/tags').then(response => response.data),
            axios.get('/api/tag/' + slug).then(response => response.data)
        ])
            .then(tagData => {
                this.tags = tagData[0].data
                this.selectedTag = tagData[1].data
                this.tagId = this.selectedTag.id
            })
    },
    methods: {
        goToField(slug) {
            window.location.href = '/field/' + slug
        },
        goToMember(memberSlug) {
            window.location.href = '/member/' + memberSlug
        },
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
    padding: 96px 0;
    @include container();
    display: flex;
    flex-direction: row;
    & {
        @include respond-to($mobile) {
            flex-direction: column;
        }
    }
    & > .list {
        flex: 1;
        margin-right: 32px;
        box-shadow: 0px 0px 10px #CCC;
        & {
            @include respond-to($mobile) {
                margin-right: 0;
                margin-bottom: 32px;
                max-height: 300px;
                overflow-y: scroll;
            }
        }
        & > .title {
            font-size: 1.5em;
            font-weight: 700;
            padding: 32px;
            padding-bottom: 12px;
        }
        & > ul {
            list-style: none;
            margin: 0;
            padding: 0;
            & > li {
                padding: 12px 32px;
                border-bottom: 1px solid #EEE;
                transition: 0.3s;
                cursor: pointer;
                &:last-child {
                    border-bottom: 0;
                }
                &:hover {
                    background-color: #999;
                    color: #FFF;
                }
                &.active {
                    background-color: #555;
                    color: #FFF;
                }
            }
        }
    }
    & > .members {
        flex: 2;
        & > .member {
            display: flex;
            flex-direction: row;
            padding: 24px;
            box-shadow: 0px 0px 10px #CCC;
            margin-bottom: 24px;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
            &:hover {
                box-shadow: 0px 0px 40px #AAA;
            }
            &:last-child {
                margin-bottom: 0;
            }
            & > .picture {
                margin-right: 24px;
                & > img {
                    width: 100px;
                    height: 100px;
                    object-fit: cover;
                    border-radius: 50%;
                }
            }
            & > .information {
                flex: 1;
                & > .name {
                    font-size: 1.2em;
                    font-weight: 700;

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
