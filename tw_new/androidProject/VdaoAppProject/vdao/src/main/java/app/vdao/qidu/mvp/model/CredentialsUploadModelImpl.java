package app.vdao.qidu.mvp.model;

import android.graphics.BitmapFactory;

import com.common.lib.base.BaseApplication;
import com.net.rx_retrofit_network.location.model.BaseResponse;
import com.net.rx_retrofit_network.location.requestbody.UploadFileRequestBody;
import com.net.rx_retrofit_network.location.retrofit.RetrofitUtil;

import java.io.File;
import java.util.HashMap;
import java.util.Map;

import app.vdao.qidu.mvp.apiservice.APIService;
import app.vdao.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdao.qidu.mvp.contract.CredentialsUploadContract;
import okhttp3.MediaType;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;

/**
 * Created by 7du-28 on 2018/3/13.
 */

public class CredentialsUploadModelImpl implements CredentialsUploadContract.Model{

    public void uploadCredentialsPic(final String path,Callback callback) {
        RetrofitUtil.getInstance(BaseApplication.getInstance());
        //APIService service = RetrofitUtil.getApi(APIService.class);
        APIService service=ApiServcieImpl.getInstance();
        Map<String, RequestBody> map = new HashMap<>();
        RequestBody tokenBody = RequestBody.create(
                MediaType.parse("multipart/form-data"), "token");
        /*RequestBody userIdBody = RequestBody.create(
                MediaType.parse("multipart/form-data"),userId);*/
        //map.put("user_id",userIdBody);

        File file = new File(path);//filePath 图片地址
        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        BitmapFactory.decodeFile(path, options);
        String type = options.outMimeType;
        RequestBody imageBody = RequestBody.create(MediaType.parse(type), file);//multipart/form-data
        UploadFileRequestBody uploadFileRequestBody = new UploadFileRequestBody(imageBody, new UploadFileRequestBody.ProgressRequestListener() {
            @Override
            public void onRequestProgress(long hasWrittenLen, long totalLen, boolean hasFinish) {
                //double r = (double) hasWrittenLen / (double) totalLen;
            }
        });
        //map.put("pic[]", imageBody);//requestBodyMap.put("file\"; filename=\"" + file.getName(), fileRequestBody);
        map.put("file\"; filename=\"" + file.getName(), uploadFileRequestBody);
        Map<String, String> headers=new HashMap<>();
        Call<BaseResponse> resultCall = service.uploadImgPhoto( "join_upload","上传证件", map);

        resultCall.enqueue(callback);
    }

}
