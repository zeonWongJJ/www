package util;

import android.content.res.Resources;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Rect;

import java.io.InputStream;

/**
 * Created by 7du-28 on 2017/9/26.
 */

public class BitmapCreate {
    public BitmapCreate() {
    }

    public static Bitmap bitmapFromResource(Resources res, int resId, int reqWidth, int reqHeight) {
        InputStream is = res.openRawResource(resId);
        return bitmapFromStream(is, (Rect)null, reqWidth, reqHeight);
    }

    public static Bitmap bitmapFromFile(String pathName, int reqWidth, int reqHeight) {
        if(reqHeight == 0 || reqWidth == 0) {
            try {
                return BitmapFactory.decodeFile(pathName);
            } catch (OutOfMemoryError var4) {
                ;
            }
        }

        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        BitmapFactory.decodeFile(pathName, options);
        options = BitmapHelper.calculateInSampleSize(options, reqWidth, reqHeight);
        return BitmapFactory.decodeFile(pathName, options);
    }

    public static Bitmap bitmapFromByteArray(byte[] data, int offset, int length, int reqWidth, int reqHeight) {
        if(reqHeight == 0 || reqWidth == 0) {
            try {
                return BitmapFactory.decodeByteArray(data, offset, length);
            } catch (OutOfMemoryError var6) {
                ;
            }
        }

        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        options.inPurgeable = true;
        BitmapFactory.decodeByteArray(data, offset, length, options);
        options = BitmapHelper.calculateInSampleSize(options, reqWidth, reqHeight);
        return BitmapFactory.decodeByteArray(data, offset, length, options);
    }

    public static Bitmap bitmapFromStream(InputStream is, int reqWidth, int reqHeight) {
        if(reqHeight == 0 || reqWidth == 0) {
            try {
                return BitmapFactory.decodeStream(is);
            } catch (OutOfMemoryError var4) {
                ;
            }
        }

        byte[] data = FileUtils.input2byte(is);
        return bitmapFromByteArray(data, 0, data.length, reqWidth, reqHeight);
    }

    public static Bitmap bitmapFromStream(InputStream is, Rect outPadding, int reqWidth, int reqHeight) {
        Bitmap bmp = null;
        if(reqHeight == 0 || reqWidth == 0) {
            try {
                return BitmapFactory.decodeStream(is);
            } catch (OutOfMemoryError var6) {
                ;
            }
        }

        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        options.inPurgeable = true;
        BitmapFactory.decodeStream(is, outPadding, options);
        options = BitmapHelper.calculateInSampleSize(options, reqWidth, reqHeight);
        bmp = BitmapFactory.decodeStream(is, outPadding, options);
        return bmp;
    }
}
