package com.example.prernapadhee.wavesoft;

import android.app.ProgressDialog;
import android.content.Intent;
import android.provider.SyncStateContract;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    private EditText username, fname, lname, email, password, retype;
    TextView unmatch, emailvalid, missing_fname, missing_lname, missing_username, missing_password, missing_email, missing_confirmpassword;
    ProgressDialog progressDialog;
    boolean flag;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        if(SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            Intent i= new Intent(this, Main3Activity.class);
            startActivity(i);
            return;
        }

        missing_confirmpassword=(TextView)findViewById(R.id.missing_confirmpassword);
        missing_email=(TextView)findViewById(R.id.missing_email);
        missing_fname=(TextView)findViewById(R.id.missing_fname);
        missing_lname=(TextView)findViewById(R.id.missing_lname);
        missing_password=(TextView)findViewById(R.id.missing_password);
        missing_username=(TextView)findViewById(R.id.missing_username);
        username=(EditText)findViewById(R.id.username);
        unmatch=(TextView)findViewById(R.id.unmatch);
        fname=(EditText)findViewById(R.id.fname);
        lname=(EditText)findViewById(R.id.lname);
        email=(EditText)findViewById(R.id.email);
        password=(EditText)findViewById(R.id.password);
        retype=(EditText)findViewById(R.id.retype);
        progressDialog = new ProgressDialog(this);
        emailvalid=(TextView)findViewById(R.id.emailvalid);

    }


    private void RegisterUser() {

        final String email_add = email.getText().toString();
        final String name = username.getText().toString();
        final String first = fname.getText().toString();
        final String last = lname.getText().toString();
        final String pass = password.getText().toString();
        final String confirm = retype.getText().toString();
        final String emailPattern = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";

        /*email .addTextChangedListener(new TextWatcher() {
            public void afterTextChanged(Editable s) {

                if (email_add.matches(emailPattern) && s.length() > 0)
                {
                    flag=true;
                }
                else
                {
                    flag=false;
                }
            }
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
                // other stuffs
            }
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                // other stuffs
            }
        });*/

        if(first.length()==0 || last.length()==0 || name.length()==0 || pass.length()==0 || confirm.length()==0 || email_add.length()==0){
            Toast.makeText(getApplicationContext(), "Required Fields Missing", Toast.LENGTH_SHORT).show();
            if(first.length()==0 && last.length()==0 && name.length()==0 && pass.length()==0 && confirm.length()==0 && email_add.length()==0){
                missing_fname.setText("*");
                missing_lname.setText("*");
                missing_username.setText("*");
                missing_password.setText("*");
                missing_email.setText("*");
                missing_confirmpassword.setText("*");
            }
            else{
                if(first.length()==0){
                    missing_fname.setText("*");
                }
                else{
                    missing_fname.setText("");
                }
                if(last.length()==0){
                    missing_lname.setText("*");
                }
                else{
                    missing_lname.setText("");
                }
                if(name.length()==0){
                    missing_username.setText("*");
                }
                else{
                    missing_username.setText("");
                }
                if(pass.length()==0){
                    missing_password.setText("*");
                }
                else{
                    missing_password.setText("");
                }
                if(email_add.length()==0){
                    missing_email.setText("*");
                }
                else {
                    missing_email.setText("");
                }
                if(confirm.length()==0){
                    missing_confirmpassword.setText("*");
                }
                else{
                    missing_confirmpassword.setText("");
                }
            }
        }
        else {



                if (pass.length() >= 6) {
                    if (confirm.equals(pass)) {
                        unmatch.setText("");
                        progressDialog.setMessage("Registering User");
                        progressDialog.show();
                        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                                Constants.URL_REGISTER,
                                new Response.Listener<String>() {
                                    @Override
                                    public void onResponse(String response) {

                                        progressDialog.dismiss();
                                        String Message = "Message";
                                        try {
                                            JSONObject jsonObject = new JSONObject(response);
                                            System.out.println(jsonObject);
                                            Toast.makeText(getApplication(), jsonObject.getString("message"), Toast.LENGTH_LONG).show();
                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }
                                    }
                                },
                                new Response.ErrorListener() {
                                    @Override
                                    public void onErrorResponse(VolleyError error) {

                                        progressDialog.hide();
                                        Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_LONG).show();
                                    }
                                }) {
                            @Override
                            protected Map<String, String> getParams() throws AuthFailureError {
                                Map<String, String> params = new HashMap<>();
                                params.put("Username", name);
                                params.put("Password", pass);
                                params.put("First_name", first);
                                params.put("Last_name", last);
                                params.put("Email", email_add);
                                return params;
                            }
                        };
                        //RequestQueue requestQueue = Volley.newRequestQueue(this);
                        //requestQueue.add(stringRequest);
                        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
                    } else {
                        unmatch.setText("PASSWORDS DONT MATCH!!!");
                    }
                } else {


                    Toast.makeText(getApplicationContext(), "PASSWORD SHOULD BE ATLEAST 6 CHARACTERS", Toast.LENGTH_SHORT).show();

                }
            }
        }

    public void function(View view){
        RegisterUser();
    }

}
