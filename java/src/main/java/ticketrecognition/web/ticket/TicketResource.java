package ticketrecognition.web.ticket;

import ticketrecognition.Role;
import ticketrecognition.dto.MetadataDto;

import javax.annotation.security.RolesAllowed;
import javax.inject.Inject;
import javax.ws.rs.Consumes;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.core.MediaType;
import java.io.IOException;
import java.io.InputStream;

@Path("/tickets/")
@RolesAllowed({Role.AD_CODE, Role.SCANNER_CODE})
public class TicketResource {

    private TicketService service;

    @POST
    @Consumes(MediaType.APPLICATION_OCTET_STREAM)
    public MetadataDto match(InputStream image) throws IOException {
        return service.match(image);
    }

    @Inject
    void setService(TicketService service) {
        this.service = service;
    }
}
