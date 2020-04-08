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
        path: '/questions/:id/edit',
        component: EditQuestionPage,
        name: 'questions.edit'
    },
    {
        path: '/my-posts',
        component: UsersPostsPage,
        name: 'my-posts',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/questions/:question',
        component: QuestionPage,
        name: 'questions.show'
    },
    {
        path: '*',
        component: NotFoundPage,
    }
];
export default  routes
