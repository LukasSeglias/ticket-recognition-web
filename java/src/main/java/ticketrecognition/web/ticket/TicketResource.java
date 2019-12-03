package ticketrecognition.web.ticket;

import ticketrecognition.Role;
import ticketrecognition.dto.MetadataDto;

import javax.annotation.security.RolesAllowed;
import javax.inject.Inject;
import javax.ws.rs.*;
import javax.ws.rs.core.MediaType;
import java.io.IOException;
import java.io.InputStream;

@Path("/tickets/")
@RolesAllowed({Role.AD_CODE, Role.SCANNER_CODE})
public class TicketResource {

    private TicketService service;

    @POST
    @Consumes(MediaType.APPLICATION_OCTET_STREAM)
    @Produces(MediaType.APPLICATION_JSON)
    public MetadataDto match(InputStream image, @HeaderParam("TypeOfFile") String typeOfFile) throws IOException {
        return service.match(image, typeOfFile);
    }

    @Inject
    void setService(TicketService service) {
        this.service = service;
    }
}
