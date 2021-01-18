package ir.amirsobhan.wallpaperapp.Databases;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import ir.amirsobhan.wallpaperapp.Model.Wallpaper;

public class WallpaperDB extends SQLiteOpenHelper {
    private final static int DB_VERSION = 1;
    private final static String DB_NAME = "wallpaperDB";
    public final static String TABLE_NAME = "wallpaper";
    public final static String KEY_ID = "id";
    public final static String ITEM_TITLE = "title";
    public final static String ITEM_TAGS = "tags";
    public final static String ITEM_LIKE = "is_like";
    public final static String ITEM_DOWNLOAD = "is_download";
    public final static String ITEM_VIEW = "is_seen";
    public final static String ITEM_PATH = "path";
    private final static String CREATE_TABLE = "CREATE TABLE " + TABLE_NAME + "("
            + KEY_ID + " INTEGER PRIMARY KEY AUTOINCREMENT,"
            + ITEM_TITLE + " TEXT,"
            + ITEM_TAGS + " TEXT,"
            + ITEM_LIKE + " INTEGER,"
            + ITEM_DOWNLOAD + " INTEGER,"
            + ITEM_VIEW + " INTEGER,"
            + ITEM_PATH + " TEXT)";

    public WallpaperDB(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        //Create Database Table
        db.execSQL(CREATE_TABLE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }

    private void DEBUG(String s){
        Log.d(WallpaperDB.class.getSimpleName(),s);
    }

    /**
     * Insert Wallpaper to local database
     *
     * @param wallpaper
     */
    public void Insert(Wallpaper wallpaper) {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put(KEY_ID, wallpaper.getId());
        values.put(ITEM_TITLE, wallpaper.getTitle());
        values.put(ITEM_TAGS, wallpaper.getTags());
        values.put(ITEM_LIKE, 0);
        values.put(ITEM_VIEW, 0);
        values.put(ITEM_DOWNLOAD, 0);
        values.put(ITEM_PATH, wallpaper.getPath());
        db.insert(TABLE_NAME, null, values);
        DEBUG("New Data Inserted");
    }

    /**
     * check item in database or not
     * @param id
     * @return
     */
    public boolean isExist(int id) {
        SQLiteDatabase db = this.getReadableDatabase();
        String sql = "SELECT * FROM " + TABLE_NAME + " WHERE " + KEY_ID + "=" + id;
        Cursor cursor = db.rawQuery(sql, null, null);
        return cursor.getCount() > 0;
    }

    /**
     * Update like status in Database
     *
     * @param id
     * @param like
     */
    public void setLike(int id, boolean like) {
        SQLiteDatabase db = this.getWritableDatabase();
        int status = (like) ? 1 : 0;
        String sql = "UPDATE " + TABLE_NAME + " SET " + ITEM_LIKE + "=" + status + " WHERE " + KEY_ID + "=" + id + "";
        db.execSQL(sql);
    }

    /**
     * check like status from local database
     *
     * @param id
     * @return
     */
    public boolean isLiked(int id) {
        SQLiteDatabase db = this.getReadableDatabase();
        String sql = "SELECT * FROM " + TABLE_NAME + " WHERE " + KEY_ID + "=" + id;
        Cursor cursor = db.rawQuery(sql, null, null);
        cursor.moveToNext();
        return cursor.getInt(cursor.getColumnIndex(ITEM_LIKE)) == 1;
    }

    /**
     * Update download status in database
     *
     * @param id
     */
    public void setDownloaded(int id) {
        SQLiteDatabase db = this.getWritableDatabase();
        String sql = "UPDATE " + TABLE_NAME + " SET " + ITEM_DOWNLOAD + "=" + "1" + " WHERE " + KEY_ID + "=" + id + "";
        db.execSQL(sql);
    }

    /**
     * Update view status in database
     * @param id
     */
    public void setView(int id){
        SQLiteDatabase db = this.getWritableDatabase();
        String sql = "UPDATE " + TABLE_NAME + " SET " + ITEM_VIEW + "=" + "1" + " WHERE " + KEY_ID + "=" + id + "";
        db.execSQL(sql);
    }

}
