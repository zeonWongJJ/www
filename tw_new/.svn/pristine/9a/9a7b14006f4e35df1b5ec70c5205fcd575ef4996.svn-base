package app.vdao.qidu.mvp.apiservice;


import app.vdao.qidu.AppApplication;
import com.net.rx_retrofit_network.location.retrofit.RetrofitUtil;

public class ApiServcieImpl {
    private ApiServcieImpl() {

    }
    public static APIService getInstance() {
        return createAPIService.apiService;
    }

    /**
     * Retrofit生成接口对象.
     */
    private static class createAPIService {
        //Retrofit会根据传入的接口类.生成实例对象.
        private static final APIService apiService = RetrofitUtil.getInstance(AppApplication.getInstance()).create(APIService.class);
    }
}
