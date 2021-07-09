<script>
import Layout from '../Layout'
import Banner from './Banner'
import About from './About'
import Project from './Project'
import Article from './Article'
import Members from './Members'
import Contact from './Contact'
import Footer from './Footer'

const selectComponent = (sectionName) => {
    switch (sectionName) {
        case 'Banner' :
            return Banner
        case 'About' :
            return About
        case 'Project' :
            return Project
        case 'Article' :
            return Article
        case 'Members' :
            return Members
        case 'Contact' :
            return Contact
        case 'Footer' :
            return Footer
    }
}

export default {
    components: {
        Layout,
        Banner,
        About,
        Project,
        Article,
        Members,
        Contact,
        Footer,
    },
    render: function (h) {
        return (
            <Layout>
                {sections.map(sectionName => {
                    const Component = selectComponent(sectionName)
                    return <Component />
                })}
            </Layout>
        )
    }
}
</script>

<style lang="scss" scoped>
.space {
    height: 48px;
}
</style>
