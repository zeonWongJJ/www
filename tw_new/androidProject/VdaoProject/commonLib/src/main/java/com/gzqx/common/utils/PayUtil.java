package com.gzqx.common.utils;

import android.app.AlertDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.util.Xml;
import android.widget.TextView;
import android.widget.Toast;

import com.gzqx.common.base.BaseApplication;
import com.gzqx.common.bean.NameValuePair;
import com.gzqx.common.httpbase.net.BaseApiService;
import com.gzqx.common.httpbase.net.RetrofitClient;
import com.tencent.mm.opensdk.modelpay.PayReq;
import com.tencent.mm.opensdk.openapi.IWXAPI;
import com.tencent.mm.opensdk.openapi.WXAPIFactory;

import org.xmlpull.v1.XmlPullParser;

import java.io.IOException;
import java.io.StringReader;
import java.io.UnsupportedEncodingException;
import java.net.InetAddress;
import java.net.NetworkInterface;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Enumeration;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.Random;

import io.reactivex.Observable;
import io.reactivex.ObservableEmitter;
import io.reactivex.ObservableOnSubscribe;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by 7du-28 on 2017/8/24.
 */

public class PayUtil {
    //http://www.cnblogs.com/fxwl/p/6000094.html
    private String testOrderNum="1504765030";
    private Context context;
    private Map<String, String> resultUnifiedOrder;
    // 商户收款账号
    private String SELLER = "1488729882";//1488729882   1450892002
    public PayUtil(Context context) {
        this.context=context;
    }
    private Disposable disposable;
    public void startPrepayTask(){
        //new GetPrepayIdTask().execute();
        final AlertDialog dialog;
        String app_tip = "提示";
        String getting_prepayid = "正在获取预支付订单...";
        dialog = new AlertDialog.Builder(context).setTitle(app_tip).setMessage(getting_prepayid).create();
        dialog.show();
        if(disposable!=null){
            disposable.dispose();
        }
        Observable observable=Observable.create(new ObservableOnSubscribe() {
            @Override
            public void subscribe(ObservableEmitter e) throws Exception {
                String url = String.format("https://api.mch.weixin.qq.com/pay/unifiedorder");
                String entity = genProductArgs();
                Log.e("orion", "genProductArgs-->"+entity);
                //byte[] buf = HttpUtil.doPost(url, entity);
                //String content = new String(buf);
                String content =HttpUtil.doPost(url, entity);
                Log.e("orion", "返回内容"+content);
                if(content!=null){
                    Map<String, String> xml = decodeXml(content);
                    e.onNext(xml);
                }else {
                    e.onComplete();
                }
            }
        });
        disposable = (Disposable)observable.subscribeOn(Schedulers.io()).unsubscribeOn(Schedulers.io()).observeOn(AndroidSchedulers.mainThread()).subscribeWith(new DisposableObserver<Map<String, String>>() {

            @Override
            public void onError(Throwable e) {
                //reDisposable(observable);
                if (dialog != null) {
                    dialog.dismiss();
                }
            }
            @Override
            public void onComplete() {
                if (dialog != null) {
                    dialog.dismiss();
                }
            }

            @Override
            public void onNext(Map<String, String> result) {
                if (dialog != null) {
                    dialog.dismiss();
                }
                resultUnifiedOrder = result;

                //调起微信支付
                sendPayReq();
            }
        });

    }

    // 商户私钥，pkcs8格式   key设置路径：微信商户平台(pay.weixin.qq.com)-->账户设置-->API安全-->密钥设置
    private String RSA_PRIVATE = "QvTcQYHYtfFBaywpv3h4XjRJTS82NqRP";//key为商户平台设置的密钥key

    private void sendPayReq(){

		/*
		* req.appId=json.getString("appid");
req.partnerId=json.getString("partnerid");
req.prepayId=json.getString("prepayid");
req.nonceStr=json.getString("noncestr");
req.timeStamp=json.getString("timestamp");
req.packageValue=json.getString("package");
req.sign=json.getString("sign");
req.extData="appdata";//optional
		*
		* */
		if(resultUnifiedOrder==null){
            return;
        }
        if (!resultUnifiedOrder.get("return_code").equals("SUCCESS")) {
            AlertDialog.Builder builder = new AlertDialog.Builder(context);
            String tip = "支付失败";
            builder.setTitle(tip);
            builder.setMessage(resultUnifiedOrder.get("return_msg"));
            builder.show();
            return;
        } else {
            if (!resultUnifiedOrder.get("result_code").equals("SUCCESS")) {
                AlertDialog.Builder builder = new AlertDialog.Builder(context);
                String tip = "订单信息";
                builder.setTitle(tip);
                builder.setMessage(resultUnifiedOrder.get("err_code_des"));
                builder.show();
                return;
            }

            IWXAPI api=WXAPIFactory.createWXAPI(context, null);
            api.registerApp(DataUtils.WECHAT_APP_ID);
            if (!api.isWXAppInstalled()) {
                //提醒用户没有按照微信
                Toast.makeText(context, "没有安装微信,请先安装微信!", Toast.LENGTH_SHORT).show();
                return;
            }
            PayReq req = new PayReq();
            /*req.appId = DataUtils.WECHAT_APP_ID;//APPID
            req.partnerId = "1450892002";//微信支付分配的商户号
            req.prepayId = resultUnifiedOrder.get("prepay_id");//预订单号
            req.packageValue = "Sign=WXPay";
            req.nonceStr = genNonceStr();
            req.timeStamp = (System.currentTimeMillis() / 1000) + "";
            req.extData			= "app data"; // optional*/

            req.appId=resultUnifiedOrder.get("appid");
            req.partnerId=resultUnifiedOrder.get("mch_id");
            req.prepayId=resultUnifiedOrder.get("prepay_id");
            //PayUtil.textView.append("微信订单号"+req.prepayId);
            req.nonceStr=resultUnifiedOrder.get("nonce_str");
            //req.timeStamp=resultUnifiedOrder.get("timestamp");
            req.timeStamp=(System.currentTimeMillis() / 1000) + "";
            //req.packageValue=resultUnifiedOrder.get("package");
            req.packageValue = "Sign=WXPay";
            //req.sign=resultUnifiedOrder.get("sign");
            Log.i("orion","开始调用了"+resultUnifiedOrder.get("trade_type")+"签名"+req.timeStamp);
            // 传递的额外信息,字符串信息,自定义格式
            //req.extData = resultUnifiedOrder.get("trade_type") +"#" + out_trade_no + "#" +total_fee;
            req.extData="appData";
            List<NameValuePair> signParams = new LinkedList<NameValuePair>();
            signParams.add(new NameValuePair("appid", req.appId));
            signParams.add(new NameValuePair("noncestr", req.nonceStr));
            signParams.add(new NameValuePair("package", req.packageValue));
            signParams.add(new NameValuePair("partnerid", req.partnerId));
            signParams.add(new NameValuePair("prepayid", req.prepayId));
            signParams.add(new NameValuePair("timestamp", req.timeStamp));
            //再次签名
            req.sign = genPackageSign(signParams);
            Log.i("orion","开始调用了");
            api.sendReq(req);
        }
    }
    private String genNonceStr() {
        try {
            Random random = new Random();
            String rStr = MD5Util.getMessageDigest(String.valueOf(
                    random.nextInt(10000)).getBytes("utf-8"));
            return rStr;
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            return null;
        }
    }

    private String genAppSign(List<NameValuePair> params) {
        StringBuilder sb = new StringBuilder();

        for (int i = 0; i < params.size(); i++) {
            sb.append(params.get(i).getName());
            sb.append('=');
            sb.append(params.get(i).getValue());
            sb.append('&');
        }
        sb.append("key=");
        sb.append(RSA_PRIVATE);// 注意：不能hardcode在客户端，建议genSign这个过程都由服务器端完成
        /*String stringA = "appid=" + req.appId + "&noncestr=" + req.nonceStr + "&package=" + req.packageValue + "&partnerid=" + req.partnerId + "&prepayid=" + req.prepayId + "&timestamp=" + req.timeStamp;
        String stringSignTemp = stringA + "&key=" + RSA_PRIVATE;*/
        String appSign = null;
        try {
            appSign = MD5Util.getMessageDigest(sb.toString().getBytes("utf-8")).toUpperCase();
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            return null;
        }
        Log.e("orion", "appSign-->"+appSign);
        return appSign;
    }


    public Map<String, String> decodeXml(String content) {
        try {
            Map<String, String> xml = new HashMap<String, String>();
            XmlPullParser parser = Xml.newPullParser();
            parser.setInput(new StringReader(content));
            int event = parser.getEventType();
            while (event != XmlPullParser.END_DOCUMENT) {
                String nodeName = parser.getName();
                switch (event) {
                    case XmlPullParser.START_DOCUMENT:
                        break;
                    case XmlPullParser.START_TAG:
                        if ("xml".equals(nodeName) == false) {
                            //实例化student对象
                            xml.put(nodeName, parser.nextText());
                        }
                        break;
                    case XmlPullParser.END_TAG:
                        break;
                }
                event = parser.next();
            }
            return xml;
        } catch (Exception e) {
            Log.e("orion", "decodeXml Exception-->"+e.toString());
        }
        return null;
    }



    private String genProductArgs() {
        StringBuffer xml = new StringBuffer();
        try {
            String nonceStr = genNonceStr();

            xml.append("</xml>");
            List<NameValuePair> packageParams = new LinkedList<NameValuePair>();
            packageParams.add(new NameValuePair("appid", DataUtils.WECHAT_APP_ID));
            packageParams.add(new NameValuePair("body", "男人肾宝"));
            //packageParams.add(new NameValuePair("input_charset", "UTF-8"));
            packageParams.add(new NameValuePair("detail", "男人喝肾宝,女人不苦恼"));
//            packageParams.add(new BasicNameValuePair("mch_id", PARTNER));
            packageParams.add(new NameValuePair("mch_id", SELLER));//微信支付分配的商户号
            packageParams.add(new NameValuePair("nonce_str", nonceStr));
            packageParams.add(new NameValuePair("notify_url", "http://www.weixin.qq.com/wxpay/pay.php"));
            packageParams.add(new NameValuePair("out_trade_no", /*testOrderNum*/System.currentTimeMillis()+""));//订单号
            //packageParams.add(new NameValuePair("spbill_create_ip", "127.0.0.1"));
            String total_fee = (int)(Float.valueOf(0.1f).floatValue()*100)+"";//总金额 分
            packageParams.add(new NameValuePair("total_fee", total_fee));
            packageParams.add(new NameValuePair("trade_type", "APP"));

            String sign = genPackageSign(packageParams);
            packageParams.add(new NameValuePair("sign", sign));

            String xmlstring = toXml(packageParams);

            return new String(xmlstring.toString().getBytes(), "ISO8859-1");//xmlstring;
        } catch (Exception e) {
            return null;
        }

    }


    private String toXml(List<NameValuePair> params) {
        StringBuilder sb = new StringBuilder();
        sb.append("<xml>");
        for (int i = 0; i < params.size(); i++) {
            sb.append("<" + params.get(i).getName() + ">");
            sb.append(params.get(i).getValue());
            sb.append("</" + params.get(i).getName() + ">");
        }
        sb.append("</xml>");
        Log.e("orion", sb.toString());
        return sb.toString();
    }


    /**
     * 生成签名
     */
    private String genPackageSign(List<NameValuePair> params) {
        StringBuilder sb = new StringBuilder();

        for (int i = 0; i < params.size(); i++) {
            sb.append(params.get(i).getName());
            sb.append('=');
            sb.append(params.get(i).getValue());
            sb.append('&');
        }
        sb.append("key=");
        sb.append(RSA_PRIVATE);
        String packageSign = MD5Util.getMessageDigest(sb.toString().getBytes()).toUpperCase();
        Log.e("orion", packageSign);
        return packageSign;
    }


    //spbill_create_ip
    /*public String getIp() {
        try {
            for (Enumeration<NetworkInterface> en = NetworkInterface
                    .getNetworkInterfaces(); en.hasMoreElements();) {
                NetworkInterface intf = en.nextElement();
                for (Enumeration<InetAddress> ipAddr = intf.getInetAddresses(); ipAddr
                        .hasMoreElements();) {
                    InetAddress inetAddress = ipAddr.nextElement();
                    // ipv4地址
                    if (!inetAddress.isLoopbackAddress()
                            && InetAddressUtils.isIPv4Address(inetAddress
                            .getHostAddress())) {
                        Log.e("TAG", "ipv4=" + inetAddress.getHostAddress());
                        return inetAddress.getHostAddress();
                    }
                }
            }
        } catch (Exception ex) {

        }
        return "192.168.1.0";
    }*/

    //退款
    private Disposable disposableRefund;
    public void startRefundTask(){
        //new GetPrepayIdTask().execute();
        final AlertDialog dialog;
        String app_tip = "提示";
        String getting_prepayid = "订单退款申请中...";
        dialog = new AlertDialog.Builder(context).setTitle(app_tip).setMessage(getting_prepayid).create();
        dialog.show();
        if(disposableRefund!=null){
            disposableRefund.dispose();
        }
        Observable observable=Observable.create(new ObservableOnSubscribe() {
            @Override
            public void subscribe(ObservableEmitter e) throws Exception {
                String url = String.format("https://api.mch.weixin.qq.com/secapi/pay/refund");
                String entity = genRefundArgs(testOrderNum);
                Log.e("orion", "genRefundArgs-->"+entity);
                //byte[] buf = HttpUtil.doPost(url, entity);
                //String content = new String(buf);
                String content =HttpUtil.doPost(url, entity);
                Log.e("orion", "返回内容"+content);
                if(content!=null){
                    Map<String, String> xml = decodeXml(content);
                    e.onNext(xml);
                }else {
                    e.onComplete();
                }
            }
        });
        disposableRefund = (Disposable)observable.subscribeOn(Schedulers.io()).unsubscribeOn(Schedulers.io()).observeOn(AndroidSchedulers.mainThread()).subscribeWith(new DisposableObserver<Map<String, String>>() {

            @Override
            public void onError(Throwable e) {
                //reDisposable(observable);
                if (dialog != null) {
                    dialog.dismiss();
                }
            }
            @Override
            public void onComplete() {
                if (dialog != null) {
                    dialog.dismiss();
                }
            }

            @Override
            public void onNext(Map<String, String> result) {
                Toast.makeText(context,""+result.toString(),Toast.LENGTH_SHORT).show();
                if (dialog != null) {
                    dialog.dismiss();
                }

            }
        });

    }

    private String genRefundArgs(String orderNum) {
        StringBuffer xml = new StringBuffer();
        try {
            String nonceStr = genNonceStr();

            xml.append("</xml>");
            List<NameValuePair> packageParams = new LinkedList<NameValuePair>();
            packageParams.add(new NameValuePair("appid", "wxd40a4f9141fe81d0"));
//            packageParams.add(new BasicNameValuePair("mch_id", PARTNER));
            packageParams.add(new NameValuePair("mch_id", SELLER));//微信支付分配的商户号
            packageParams.add(new NameValuePair("nonce_str", nonceStr));
            //packageParams.add(new NameValuePair("out_trade_no", ""+orderNum));//订单号
            packageParams.add(new NameValuePair("out_refund_no", ""+orderNum));//商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
            //packageParams.add(new NameValuePair("spbill_create_ip", "127.0.0.1"));
            String totalFee = (int)(Float.valueOf(0.1f).floatValue()*100)+"";//总金额 分
            packageParams.add(new NameValuePair("total_fee", totalFee));//订单总金额，单位为分，只能为整数
            packageParams.add(new NameValuePair("refund_fee", totalFee));
            //transaction_id out_trade_no 二选一
            packageParams.add(new NameValuePair("transaction_id", "wx2017090715314099f0cce8920052322118"));//微信生成的订单号，在支付通知中有返回
            packageParams.add(new NameValuePair("refund_desc", "不想要了"));//退款原因
            String sign = genPackageSign(packageParams);
            packageParams.add(new NameValuePair("sign", sign));

            String xmlstring = toXml(packageParams);

            return new String(xmlstring.toString().getBytes(), "ISO8859-1");//xmlstring;
        } catch (Exception e) {
            return null;
        }

    }
}
