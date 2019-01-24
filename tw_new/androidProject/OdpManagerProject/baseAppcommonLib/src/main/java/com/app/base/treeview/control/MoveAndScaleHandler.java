package com.app.base.treeview.control;

import android.content.Context;
import android.util.Log;
import android.view.MotionEvent;
import android.view.ScaleGestureDetector;
import android.view.View;

import com.nineoldandroids.view.ViewHelper;

/**
 * Created by owant on 09/02/2017.
 */

public class MoveAndScaleHandler implements ScaleGestureDetector.OnScaleGestureListener {

    static final float max_scale = 1.2f;
    static final float min_scale = 0.3f;

    /**
     * 作用于的View
     */
    private View mView;

    private int lastX = 0;
    private int lastY = 0;

    private int mode = 0;

    private ScaleGestureDetector mScaleGestureDetector;
    private Context mContext;

    public MoveAndScaleHandler(Context context, View view) {
        this.mView = view;
        this.mContext = context;
        mScaleGestureDetector = new ScaleGestureDetector(mContext, this);
    }

    public boolean onTouchEvent(MotionEvent event) {

        int currentX = (int) event.getRawX();//获得手指当前的坐标,相对于屏幕
        int currentY = (int) event.getRawY();

        switch (event.getAction() & MotionEvent.ACTION_MASK) {
            case MotionEvent.ACTION_DOWN:
                mode = 1;
                break;
            case MotionEvent.ACTION_UP:
                mode = 0;
                break;
            case MotionEvent.ACTION_POINTER_UP:
                //将模式进行为负数这样，多指下，抬起不会触发移动
                mode = -2;
                break;
            case MotionEvent.ACTION_POINTER_DOWN:
                mode += 1;
                break;

            case MotionEvent.ACTION_MOVE:
                //Log.i("bbbbbbb","ACTION_MOVE---->"+mode);
                if (mode >= 2) {
                    if(spacing(event)>100){
                        //缩放
                        //mScaleGestureDetector.onTouchEvent(event);
                    }

                } else if (mode == 1&&(event.getPointerCount() == 1)) {
                    int deltaX = currentX - lastX;
                    int deltaY = currentY - lastY;

                    int translationX = (int) ViewHelper.getTranslationX(mView) + deltaX;
                    int translationY = (int) ViewHelper.getTranslationY(mView) + deltaY;

                    ViewHelper.setTranslationX(mView, translationX);
                    ViewHelper.setTranslationY(mView, translationY);
                }
                break;
        }

        lastX = currentX;
        lastY = currentY;

        return true;

    }

    /**
     * 两点之间的距离
     *
     * @param event
     * @return
     */
    private float spacing(MotionEvent event) {
        if (event.getPointerCount() == 2) {
            float x = event.getX(0) - event.getX(1);
            float y = event.getY(0) - event.getY(1);
            return (float) Math.sqrt(x * x + y * y);
        }
        return 0;
    }
    private float scale;
    private float preScale = 1;// 默认前一次缩放比例为1
    @Override
    public boolean onScale(ScaleGestureDetector detector) {

        /*float scaleFactor = detector.getScaleFactor();

        if (scaleFactor >= max_scale) {
            scaleFactor = max_scale;
        }
        if (scaleFactor <= min_scale) {
            scaleFactor = min_scale;
        }

        float old = mView.getScaleX();
        if (Math.abs(scaleFactor - old) > 0.6 || Math.abs(scaleFactor - old) < 0.02) {
            //忽略
        } else {
            ViewHelper.setScaleX(mView, scaleFactor);
            ViewHelper.setScaleY(mView, scaleFactor);
        }*/




        float previousSpan = detector.getPreviousSpan();
        float currentSpan = detector.getCurrentSpan();
        if (currentSpan < previousSpan) {
            // 缩小
            // scale = preScale-detector.getScaleFactor()/3;
            scale = preScale - (previousSpan - currentSpan) / 1000;
        } else {
            // 放大
            // scale = preScale+detector.getScaleFactor()/3;
            scale = preScale + (currentSpan - previousSpan) / 1000;
        }

        // 缩放view
        ViewHelper.setScaleX(mView, scale );// x方向上缩小
        ViewHelper.setScaleY(mView, scale );// y方向上缩小
        return false;
    }

    @Override
    public boolean onScaleBegin(ScaleGestureDetector detector) {
        return true;
    }

    @Override
    public void onScaleEnd(ScaleGestureDetector detector) {
    }
}
