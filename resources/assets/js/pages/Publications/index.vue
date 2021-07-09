<template>
    <Layout>
        <section class="wrapper">
            <div class="title bg-main4 color-main6">
                <span class="color-main4">Publications</span>
            </div>
            <div
                class="publications"
                v-for="(type, index) in displayPublications"
                :key="index"
            >
                <div class="type">
                    <div>{{ type.name }}</div>
                </div>
                <div class="list">
                    <div 
                        class="publication"
                        v-for="(publication, index) in type.publications"
                        :key="index"
                    >
                        <p v-html="publication.detail" />
                        <div class="membersWrapper">
                            <div class="members">
                                <div
                                    class="member imgWrapper"
                                    v-for="(publicationMember, index) in publication.publication_members"
                                    :key="index"
                                >
                                    <a :href="`/member/${publicationMember.members.id}`">
                                        <img
                                            :src="'/' + publicationMember.members.images.path"
                                            :alt="publicationMember.members.name"
                                        />
                                        <div class="overlay filter" />
                                    </a>
                                </div>
                            </div>
                            <div class="line"></div>
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
            publications: []
        }
    },
    computed: {
        displayPublications() {
            return this.publications.map(type => {
                return {
                    ...type,
                    name: this._i18n.locale === 'th' ? type.th_name : type.en_name,
                    publications: type.publications.map(publication => {
                        return {
                            ...publication,
                            publication_members: publication.publication_members
                                .map(publicationMember => {
                                    return {
                                        ...publicationMember,
                                        members: {
                                            ...publicationMember.members,
                                            name: this._i18n.locale === 'th' ? publicationMember.members.th_name : publicationMember.members.en_name,
                                        }
                                    }
                                })
                                .sort((publicationMemberA, publicationMemberB) => {
                                    return publicationMemberA.order_member - publicationMemberB.order_member
                                })
                        }
                    })
                }
            })
        }
    },
    mounted() {
        axios.get('/api/publications')
            .then(response => response.data)
            .then(responseBody => {
                this.publications = responseBody.data
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
    & > .publications {
        margin-top: 56px;
        margin-bottom: 24px;
        & > .type {
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
            & > .publication {
                background-color: #FFF;
                position: relative;
                box-shadow: 0px 0px 10px #CCC;
                border-radius: 8px;
                padding: 32px;
                padding-bottom: 104px;
                margin: 24px 0;
                transition: 0.3s;
                &:hover {
                    box-shadow: 0px 0px 40px #AAA;
                }
                & > .membersWrapper {
                    position: relative;
                    & > .members {
                        position: absolute;
                        z-index: 50;
                        left: 0;
                        right: 0;
                        display: flex;
                        flex-direction: row;
                        justify-content: flex-end;
                        & > .member {
                            margin-right: 12px;
                            & img {
                                $imageSize: 80px;
                                width: $imageSize;
                                height: $imageSize;
                                max-width: $imageSize;
                                max-height: $imageSize;
                                min-width: $imageSize;
                                min-height: $imageSize;
                                object-fit: cover;
                                border-radius: 50%;
                            }
                        }
                    }
                    & > .line {
                        position: absolute;
                        background-color: #EEE;
                        width: 100%;
                        height: 2px;
                        top: 40px;
                        margin-top: -1px;
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
