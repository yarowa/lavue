
import QuestionsPage from "../components/pages/QuestionsPage";
import UsersPostsPage from "../components/pages/UsersPostsPage";
import QuestionPage from "../components/pages/QuestionPage";
import NotFoundPage from "../components/pages/NotFoundPage";
import CreateQuestionPage from "../components/pages/CreateQuestionPage";
import EditQuestionPage from "../components/pages/EditQuestionPage";

const routes = [
    {
        path: '/',
        component: QuestionsPage,
        name: 'home'
    },
    {
        path: '/questions',
        component: QuestionsPage,
        name: 'questions'
    },
    {
        path: '/questions/create',
        component: CreateQuestionPage,
        name: 'questions.create'
    },
    {
        path: '/questions/:id/edit', //this.$router.params.id
        component: EditQuestionPage,
        name: 'questions.edit'
    },
    {
        path: '/home',
        component: UsersPostsPage,
        name: 'my-posts',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/questions/:slug',
        component: QuestionPage,
        name: 'questions.show',
        props: true,
    },
    {
        path: '*',
        component: NotFoundPage
    }
]
export default  routes
