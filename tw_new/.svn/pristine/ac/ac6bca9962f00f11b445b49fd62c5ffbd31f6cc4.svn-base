package com.printer.receipt;

import android.app.Application;
import android.util.Log;

import com.android.print.demo.loghelper.LogcatHelper;
import com.printer.receipt.global.GlobalContants;
import com.printer.receipt.utils.CrashHandler;
import com.printer.receipt.utils.PrefUtils;
import com.printer.sdk.PrinterConstants;

/**
 * 
 * @author vector
 * @Description: 锟斤拷锟斤拷锟斤拷实锟斤拷锟斤拷锟斤拷锟斤拷痛锟斤拷锟角帮拷锟接︼拷贸锟斤拷锟�,
 *               锟斤拷锟斤拷要锟斤拷锟藉单锟侥硷拷application锟斤拷锟斤拷锟斤拷
 * @date 2015-3-29 锟斤拷锟斤拷4:14:17
 */
public class CashRegisterApplication extends Application {

	private static final String TAG = "CashRegisterApplication";
	private static boolean isConnected;

	// TSPL指令添加的全局变量
	// 设置界面是否选中TSPL指令框
	public static boolean isSettingTSPL=true;//设置默认为CPCL
	// 设置界面打印内容的左边距
	public static int MARGINLEFT = 0;
	// 设置界面打印内容的上边距
	public static int MARGINTOP = 0;
	// 打印的标签份数
	public static int PRINT_NUMBER = 1;

	// oncreate锟斤拷锟轿猴拷activity锟斤拷service,receiver之前使锟矫ｏ拷锟斤拷锟斤拷content providers
	@Override
	public void onCreate() {
		// TODO Auto-generated method stub
		super.onCreate();
		mContext=this;
		// Thread.setDefaultUncaughtExceptionHandler(new MyExceptionHandler());
		CrashHandler crashHandler = CrashHandler.getInstance();
		// 注册crashHandler
		crashHandler.init(getApplicationContext());
		Log.i(TAG, "DemoApplication>>>>>>>>>>>>>>>");
		LogcatHelper.getInstance(this).start();
		PrefUtils.setBoolean(getApplicationContext(), GlobalContants.CONNECTSTATE, false);

		//设置打印前开钱箱
		PrefUtils.setInt(mContext, "isOpenCash", 1);
		init();

	}

	//初始化默认的参数
	private void init(){
		PrefUtils.setInt(getApplicationContext(), GlobalContants.PAPERWIDTH, PrinterConstants.paperWidth);

	}

	private static CashRegisterApplication mContext;
	public static CashRegisterApplication getInstance() {
		return mContext;
	}
	// //锟斤拷锟斤拷未锟斤拷锟斤拷锟斤拷斐�
	// private class MyExceptionHandler implements UncaughtExceptionHandler{
	//
	//
	// @Override
	// public void uncaughtException(Thread thread, Throwable ex) {
	// //锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷状态锟斤拷未锟斤拷锟斤拷
	// PrefUtils.setBoolean(getApplicationContext(),
	// GlobalContants.CONNECTSTATE, false);
	// // TODO Auto-generated method stub
	// // Logger.i(TAG, "锟斤拷锟斤拷锟斤拷锟届常锟斤拷锟斤拷锟斤拷锟界捕锟斤拷锟斤拷");
	// System.out.println("锟斤拷锟斤拷锟届常锟斤拷锟金不诧拷锟斤拷锟斤拷");
	// // StringWriter wr = new StringWriter();
	// // PrintWriter err = new PrintWriter(wr);
	// // ex.printStackTrace(err);
	// //// System.out.println("??/"+wr.toString());
	// // File file = new
	// File(Environment.getExternalStorageDirectory(),"err.log");
	// // try {
	// // FileOutputStream fos = new FileOutputStream(file);
	// // fos.write(wr.toString().getBytes());
	// // fos.close();
	// // } catch (Exception e) {
	// // // TODO Auto-generated catch block
	// // e.printStackTrace();
	// // }
	// //锟斤拷杀----系统锟斤拷为锟角凤拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷迅锟斤拷锟斤拷锟斤拷
	// // android.os.Process.killProcess(android.os.Process.myPid());
	// //一同锟斤拷锟斤拷锟届常锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷状态锟斤拷未锟斤拷锟斤拷
	// PrefUtils.setBoolean(getApplicationContext(),
	// GlobalContants.CONNECTSTATE, false);
	// }
	//
	// }

}
