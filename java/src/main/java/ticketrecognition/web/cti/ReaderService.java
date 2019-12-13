package ticketrecognition.web.cti;

import com.bfh.ticket.*;

import static com.bfh.ticket.MetadataReaderOptions.USE_DEFAULT_RATIO_THRESHOLD;

public class ReaderService {

    private final MetadataReader reader;

    public ReaderService() {
        this.reader = new MetadataReader(Algorithm.SIFT, new MetadataReaderOptions(USE_DEFAULT_RATIO_THRESHOLD, "deu"));
    }

    public Metadata read(Ticket ticket, TicketImage ticketImage) {
        return reader.read(ticket, ticketImage);
    }
}
