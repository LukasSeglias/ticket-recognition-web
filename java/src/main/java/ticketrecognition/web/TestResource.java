package ticketrecognition.web;

import javax.inject.Inject;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

@Path("/")
public class TestResource {

    @Inject
    TestService service;

    @GET
    @Produces({"application/json"})
    public TestClass getTest() {
        return service.testObj();
    }
}