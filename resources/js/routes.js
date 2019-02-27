import Home from './components/Home';
import Employees from './components/Employees/DashBoard';
import EmployeeItem from './components/Employees/Item';
import EmployeeAdd from './components/Employees/NewItem';
import Departments from './components/Departments/DashBoard';
import DepartmentItem from './components/Departments/Item';
import DepartmentAdd from './components/Departments/NewItem';
import NotFound from './components/NotFound';

export const routes = [
    {path: '/', component: Home, name: 'Home'},
    {path: '/employees', component: Employees, name: 'Employees'},
    {path: '/employees/add', component: EmployeeAdd, name: 'EmployeeAdd'},
    {path: '/employees/:id', component: EmployeeItem, name: 'EmployeeItem'},
    {path: '/departments', component: Departments, name: 'Departments'},
    {path: '/departments/add', component: DepartmentAdd, name: 'DepartmentAdd'},
    {path: '/departments/:id', component: DepartmentItem, name: 'DepartmentItem'},
    {path: "*", component: NotFound}
];

routes.forEach(route => {
    if (typeof route.component['created'] !== 'function') {
        route.component['created'] = function () {
        };
    }

    if (typeof route.component.methods === 'undefined') {
        route.component.methods = {};
    }
    route.component.methods[route.name + 'created'] = route.component['created'];

    if (typeof route.component.methods['fetchData'] === 'undefined') {
        route.component.methods['fetchData'] = function () {
            axios
                .post("/fetchData", {
                    path: this.$route.name,
                    additional: Object.assign(this.$route.params, this.$route.query)
                })
                .then(response => {
                    if (response.data.redirect) {
                        this.$router.push(response.data.redirect);
                        return;
                    }
                    this.$root.$emit("dataFetched", response.data);
                })
                .catch(error => {
                    this.$messenger("Не удалось получить данные", true)
                    setTimeout(this.fetchData, 5000);
                });
        }
    }

    route.component['created'] = function () {
        this.$root.$off("dataFetched");
        this[route.name + 'created']();
        this.fetchData();
    }
});