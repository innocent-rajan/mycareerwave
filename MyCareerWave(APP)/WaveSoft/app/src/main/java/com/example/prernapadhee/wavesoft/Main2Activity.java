package com.example.prernapadhee.wavesoft;

import android.app.ProgressDialog;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Main2Activity extends AppCompatActivity {

    private EditText username, password;
    private ProgressDialog progressDialog;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main2);

        if(SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            Intent i= new Intent(this, Main3Activity.class);
            startActivity(i);
            return;
        }
        username = (EditText)findViewById(R.id.username);
        password = (EditText)findViewById(R.id.password);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Please wait...");

    }
    private void userLogin(){
        final String name = username.getText().toString();
        final String pass = password.getText().toString();

        progressDialog.show();
        StringRequest stringRequest = new StringRequest(
                Request.Method.POST,
                Constants.URL_LOGIN,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        progressDialog.dismiss();
                        try {
                            JSONObject obj = new JSONObject(response);
                            if(!obj.getBoolean("error")){

                                SharedPrefManager.getInstance(getApplicationContext()).userLogin(
                                        obj.getInt("id"),
                                        obj.getString("Username"),
                                        obj.getString("Email"),
                                        obj.getString("First_name"),
                                        obj.getString("Last_name")
                                );
                                Intent intent = new Intent(Main2Activity.this, Main3Activity.class);
                                startActivity(intent);
                                finish();
                            }
                            else{

                                Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_LONG).show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {

                        progressDialog.dismiss();
                        Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }
        ){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("Username", name);
                params.put("Password", pass);
                return params;
            }
        };

        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);

    }

    public void function(View view){
        userLogin();

    }

    public void function1(View view){
        Intent i = new Intent(this, MainActivity.class);
        startActivity(i);
    }

}
