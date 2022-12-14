/****** Object:  Table [dbo].[documentosPago]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[documentosPago](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[formaPago] [int] NULL,
	[institucionEmisora] [varchar](120) NULL,
	[numeroDocumento] [varchar](40) NULL,
	[fechaEmision] [date] NULL,
	[importeTotal] [decimal](18, 2) NULL,
	[saldoDisponible] [decimal](18, 2) NULL,
	[importePedimento] [decimal](18, 2) NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_DocumentosPago] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
