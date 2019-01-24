export default{
    state:{
         customerPage : 1,  //客户列表 页码
         addCustomerListPage : 1,       // 添加客户 客户列表 页码
         auditCustomer : 1,             // 客户审核 页面
    },
    mutations:{
        customerPage : (state , page ) => {
            state.customerPage = page;
        },
        addCustomerListPage : (state , page) => {
            state.addCustomerListPage = page;
        },
        auditCustomer : (state , page) => {
            state.auditCustomer = page;
        }
    },
}