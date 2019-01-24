package audiorecord.lib.audioUtil.widget;

import android.content.Context;
import android.os.Handler;
import android.support.annotation.Nullable;
import android.util.AttributeSet;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;

import java.util.Calendar;

/**
 * 录音view
 */

public class RecordSoundImageView extends Button implements View.OnTouchListener{

    private static final long LONG_PRESS_TIME = 500;
    /**
     * 当前点击时间
     */
    private long mCurrentClickTime;
    private Handler mBaseHandler = new Handler();
    private OnRecordListener recordListener;

    public RecordSoundImageView(Context context) {
        super(context);
        initTouchListener();
    }

    public RecordSoundImageView(Context context, @Nullable AttributeSet attrs) {
        super(context, attrs);
        initTouchListener();

    }

    public RecordSoundImageView(Context context, @Nullable AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        initTouchListener();
    }

    private void initTouchListener(){
        this.setOnTouchListener(this);
    }
    private float downY;
    private float moveY;
    private boolean isCanceled;
    @Override
    public boolean onTouch(View v, MotionEvent event) {
        //当前坐标
        switch (event.getAction()) {
            case MotionEvent.ACTION_DOWN:
                isCanceled = false;
                downY=event.getY();
                if(recordListener!=null){
                    recordListener.onQuickClick();
                }
                //记录当前点击的时间
                mCurrentClickTime = Calendar.getInstance().getTimeInMillis();
                //开一个线程，延迟LONG_PRESS_TIME时间
                mLongPressedThread = new LongPressedThread();
                mBaseHandler.postDelayed(mLongPressedThread,LONG_PRESS_TIME);
                break;
            case MotionEvent.ACTION_MOVE:
                /*int x = (int) event.getRawX();
                int y = (int) event.getRawY();
                if (!isTouchPointInView(this, x, y)) {
                    mBaseHandler.removeCallbacks(mLongPressedThread);
                    if(recordListener!=null){
                        recordListener.onEndRecord();
                    }
                }*/
                moveY= event.getY();
                if (downY - moveY >= 100) {
                    isCanceled = true;
                    if(recordListener!=null){
                        //mBaseHandler.removeCallbacks(mLongPressedThread);
                        recordListener.onChangePopBackground(true);//表示松手即将取消
                    }
                }
                if (downY - moveY < 100) {
                    isCanceled = false;
                    if(recordListener!=null){
                        //mBaseHandler.removeCallbacks(mLongPressedThread);
                        recordListener.onChangePopBackground(false);//表示松手即将取消
                    }
                }
                break;
            case MotionEvent.ACTION_UP: {
                mBaseHandler.removeCallbacks(mLongPressedThread);
                if(isCanceled){
                    if(recordListener!=null){
                        recordListener.onCancelRecord();
                    }
                }else {
                    if (recordListener != null) {
                        recordListener.onEndRecord();
                    }
                }
                break;
            }
        }
        return true;
    }
    @Override
    public boolean dispatchTouchEvent(MotionEvent ev) {
        getParent().requestDisallowInterceptTouchEvent(true);//阻止父层的View截获touch事件
        return super.dispatchTouchEvent(ev);
    }
    private boolean isTouchPointInView(View view, int x, int y) {
        if (view == null) {
            return false;
        }
        int[] location = new int[2];
        view.getLocationOnScreen(location);
        int left = location[0];
        int top = location[1];
        int right = left + view.getMeasuredWidth();
        int bottom = top + view.getMeasuredHeight();
        //view.isClickable() &&
        if (y >= top && y <= bottom && x >= left
                && x <= right) {
            return true;
        }
        return false;
    }
    public void setOnRecordListener(OnRecordListener recordListener){
        this.recordListener=recordListener;
    }
    public interface OnRecordListener{
        /**
         * 开始录音的时候
         */
        void onStartRecord();
        /**
         * 结束录音的时候
         */
        void onEndRecord();
        /**
         * 快速点击的时候
         */
        void onQuickClick();

        void onCancelRecord();

        void onChangePopBackground(boolean isCancel);
    }

    private LongPressedThread mLongPressedThread;
    public class LongPressedThread implements Runnable {
        @Override
        public void run() {
            //这里处理长按事件
            if(recordListener!=null){
                recordListener.onStartRecord();
            }
        }
    }
}
