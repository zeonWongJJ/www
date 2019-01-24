webpackJsonp([18],{"6Qob":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=s("Dd8w"),n=s.n(r),o={name:"LoginForm",props:{userNameRules:{type:Array,default:function(){return[{required:!0,message:"账号不能为空",trigger:"blur"}]}},isLoading:{type:Boolean,default:function(){return!1}},passwordRules:{type:Array,default:function(){return[{required:!0,message:"密码不能为空",trigger:"blur"}]}}},data:function(){return{form:{userName:"test1",password:"123456"}}},computed:{rules:function(){return{userName:this.userNameRules,password:this.passwordRules}}},methods:{handleSubmit:function(){var e=this;this.$refs.loginForm.validate(function(t){t&&e.$emit("on-success-valid",{userName:e.form.userName,password:e.form.password})})}}},a={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("Form",{ref:"loginForm",attrs:{model:e.form,rules:e.rules},nativeOn:{keydown:function(t){return"button"in t||!e._k(t.keyCode,"enter",13,t.key,"Enter")?e.handleSubmit(t):null}}},[s("FormItem",{attrs:{prop:"userName"}},[s("Input",{attrs:{disabled:e.isLoading,placeholder:"请输入用户名"},model:{value:e.form.userName,callback:function(t){e.$set(e.form,"userName",t)},expression:"form.userName"}},[s("span",{attrs:{slot:"prepend"},slot:"prepend"},[s("Icon",{attrs:{size:16,type:"ios-person"}})],1)])],1),e._v(" "),s("FormItem",{attrs:{prop:"password"}},[s("Input",{attrs:{disabled:e.isLoading,type:"password",placeholder:"请输入密码"},model:{value:e.form.password,callback:function(t){e.$set(e.form,"password",t)},expression:"form.password"}},[s("span",{attrs:{slot:"prepend"},slot:"prepend"},[s("Icon",{attrs:{size:14,type:"md-lock"}})],1)])],1),e._v(" "),s("FormItem",[s("Button",{attrs:{type:"primary",long:"",loading:e.isLoading},on:{click:e.handleSubmit}},[e._v("登录")])],1)],1)},staticRenderFns:[]},i=s("VU/8")(o,a,!1,null,null,null).exports,u=s("NYxO"),l={data:function(){return{isLoading:!1}},components:{LoginForm:i},methods:n()({},Object(u.b)(["handleLogin"]),{handleSubmit:function(e){var t=this,s=e.userName,r=e.password;this.isLoading=!0,this.handleLogin({userName:s,password:r}).then(function(e){t.isLoading=!1,t.$router.push({name:"_home"})}).catch(function(e){t.isLoading=!1})}})},d={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"login"},[t("div",{staticClass:"login-con"},[t("Card",{attrs:{icon:"log-in",title:"欢迎登录",bordered:!1}},[t("div",{staticClass:"form-con"},[t("login-form",{attrs:{isLoading:this.isLoading},on:{"on-success-valid":this.handleSubmit}}),this._v(" "),t("p",{staticClass:"login-tip"},[this._v("这里是登录提示")])],1)])],1)])},staticRenderFns:[]};var m=s("VU/8")(l,d,!1,function(e){s("IfxG")},null,null);t.default=m.exports},IfxG:function(e,t){}});
//# sourceMappingURL=18.2aac974e995d2b1874ce.js.map